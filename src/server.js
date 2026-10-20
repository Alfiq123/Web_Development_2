/**
 * Buku Tamu - server HTTP murni Node.js (tanpa framework) + node:sqlite.
 *
 * Jalankan:  npm start        (atau npm run dev untuk mode watch)
 * Env:       PORT (3000), DB_PATH (./data/guestbook.db), SCHEMA_DIR (./init.sql)
 */
import http from "node:http";
import { fileURLToPath } from "node:url";
import { openDatabase, closeDatabase, insertMessage, listMessages } from "./db.js";
import { renderHome, renderError, LIMITS } from "./views.js";

const PORT = Number(process.env.PORT ?? 3000);
const HOST = process.env.HOST ?? "0.0.0.0";
const DB_PATH = process.env.DB_PATH ?? "./data/guestbook.db";
const SCHEMA_DIR = process.env.SCHEMA_DIR ?? fileURLToPath(new URL("../init.sql", import.meta.url));

/** Batas pembuangan body yang melebihi ukuran maksimum (jaring pengaman DoS). */
const DISCARD_LIMIT = 1024 * 1024; // 1 MB

const SECURITY_HEADERS = {
  "X-Content-Type-Options": "nosniff",
  "Referrer-Policy": "no-referrer",
  "Content-Security-Policy":
    "default-src 'none'; style-src 'unsafe-inline'; form-action 'self'; base-uri 'none'",
};

/** Payload valid yang terakhir dikirim (untuk mengisi ulang form). */
function emptyValues() {
  return { name: "", body: "" };
}

/* ------------------------------------------------------------------ */
/* Helper response                                                     */
/* ------------------------------------------------------------------ */

/**
 * Kirim respons HTML.
 * @param {http.ServerResponse} res
 * @param {number} status
 * @param {string} html
 * @param {boolean} isHead
 */
function sendHtml(res, status, html, isHead = false) {
  const body = Buffer.from(html, "utf8");
  res.writeHead(status, {
    ...SECURITY_HEADERS,
    "Content-Type": "text/html; charset=utf-8",
    "Content-Length": body.length,
  });
  res.end(isHead ? undefined : body);
}

/**
 * Kirim respons teks polos.
 * @param {http.ServerResponse} res
 * @param {number} status
 * @param {string} text
 * @param {boolean} isHead
 */
function sendText(res, status, text, isHead = false) {
  const body = Buffer.from(text, "utf8");
  res.writeHead(status, {
    ...SECURITY_HEADERS,
    "Content-Type": "text/plain; charset=utf-8",
    "Content-Length": body.length,
  });
  res.end(isHead ? undefined : body);
}

/* ------------------------------------------------------------------ */
/* Request body                                                        */
/* ------------------------------------------------------------------ */

/**
 * Baca body request dengan batas ukuran.
 * Begitu batas terlampaui, janji langsung ditolak agar respons 413 bisa
 * dikirim segera; sisa data yang masuk dibuang (Node melakukan dump) sehingga
 * klien tetap menerima respons. Batas pembuangan DISCARD_LIMIT mencegah
 * klien menuang data tanpa henti.
 * @param {http.IncomingMessage} req
 * @param {number} maxBytes
 * @returns {Promise<string>}
 */
function readBody(req, maxBytes) {
  return new Promise((resolve, reject) => {
    const chunks = [];
    let size = 0;
    let overflow = false;
    let settled = false;

    const fail = (err) => {
      if (!settled) {
        settled = true;
        chunks.length = 0;
        reject(err);
      }
    };

    req.on("data", (chunk) => {
      size += chunk.length;
      if (overflow) {
        // Jaring pengaman: hentikan klien yang terus menuang data.
        if (size > DISCARD_LIMIT) req.destroy();
        return;
      }
      if (size > maxBytes) {
        overflow = true;
        const err = new Error("Payload terlalu besar");
        err.code = "HTTP_413";
        fail(err);
        return;
      }
      chunks.push(chunk);
    });

    req.on("end", () => {
      if (settled) return;
      settled = true;
      resolve(Buffer.concat(chunks).toString("utf8"));
    });

    req.on("error", fail);
  });
}

/* ------------------------------------------------------------------ */
/* Validasi                                                             */
/* ------------------------------------------------------------------ */

/**
 * Validasi isi form buku tamu.
 * @param {URLSearchParams} fields
 * @returns {{ ok: true, value: {name: string, body: string} } | { ok: false, error: string, values: {name: string, body: string} }}
 */
function validateMessage(fields) {
  const name = (fields.get("name") ?? "").trim();
  const body = (fields.get("body") ?? "").trim();

  if (name.length === 0) {
    return { ok: false, error: "Nama wajib diisi.", values: { name, body } };
  }
  if (name.length > LIMITS.MAX_NAME_LENGTH) {
    return {
      ok: false,
      error: `Nama maksimal ${LIMITS.MAX_NAME_LENGTH} karakter.`,
      values: { name, body },
    };
  }
  if (body.length === 0) {
    return { ok: false, error: "Pesan wajib diisi.", values: { name, body } };
  }
  if (body.length > LIMITS.MAX_BODY_LENGTH) {
    return {
      ok: false,
      error: `Pesan maksimal ${LIMITS.MAX_BODY_LENGTH} karakter.`,
      values: { name, body },
    };
  }

  return { ok: true, value: { name, body } };
}

/* ------------------------------------------------------------------ */
/* Handler                                                             */
/* ------------------------------------------------------------------ */

/**
 * GET / - tampilkan halaman utama.
 * @param {http.IncomingMessage} req
 * @param {http.ServerResponse} res
 */
function handleHome(req, res) {
  const isHead = req.method === "HEAD";
  const url = new URL(req.url ?? "/", "http://localhost");
  const messages = listMessages(LIMITS.LIST_LIMIT);
  const notice = url.searchParams.get("saved") !== null ? "Pesan berhasil dikirim." : null;

  sendHtml(res, 200, renderHome({ messages, values: emptyValues(), notice }), isHead);
}

/**
 * POST / - simpan pesan baru.
 * @param {http.IncomingMessage} req
 * @param {http.ServerResponse} res
 */
async function handleHomePost(req, res) {
  const isHead = req.method === "HEAD";
  const contentType = (req.headers["content-type"] ?? "").split(";")[0].trim().toLowerCase();

  if (contentType !== "application/x-www-form-urlencoded") {
    sendHtml(res, 400, renderError({
      status: 400,
      title: "Permintaan Tidak Valid",
      message: "Content-Type harus application/x-www-form-urlencoded.",
    }), isHead);
    return;
  }

  let raw;
  try {
    raw = await readBody(req, LIMITS.MAX_BODY_BYTES);
  } catch (err) {
    if (err.code === "HTTP_413") {
      sendHtml(res, 413, renderError({
        status: 413,
        title: "Data Terlalu Besar",
        message: `Ukuran pesan maksimal ${Math.floor(LIMITS.MAX_BODY_BYTES / 1024)} KB.`,
      }), isHead);
      return;
    }
    sendText(res, 400, "Gagal membaca body permintaan.", isHead);
    return;
  }

  const fields = new URLSearchParams(raw);
  const result = validateMessage(fields);

  if (!result.ok) {
    sendHtml(res, 400, renderHome({
      messages: listMessages(LIMITS.LIST_LIMIT),
      values: result.values,
      error: result.error,
    }), isHead);
    return;
  }

  insertMessage(result.value);

  // Post/Redirect/Get agar refresh tidak mengirim ulang pesan.
  res.writeHead(303, { ...SECURITY_HEADERS, Location: "/?saved=1" });
  res.end();
}

/* ------------------------------------------------------------------ */
/* Server                                                               */
/* ------------------------------------------------------------------ */

openDatabase(DB_PATH, SCHEMA_DIR);

const server = http.createServer(async (req, res) => {
  const isHead = req.method === "HEAD";
  const method = isHead ? "GET" : req.method;
  let pathname = "/";
  try {
    pathname = new URL(req.url ?? "/", "http://localhost").pathname;
  } catch {
    sendText(res, 400, "URL tidak valid.", isHead);
    return;
  }

  if (pathname !== "/") {
    sendHtml(res, 404, renderError({
      status: 404,
      title: "Halaman Tidak Ditemukan",
      message: "Halaman yang Anda tuju tidak tersedia.",
    }), isHead);
    return;
  }

  if (method === "GET") {
    handleHome(req, res);
    return;
  }

  if (method === "POST") {
    try {
      await handleHomePost(req, res);
    } catch (err) {
      console.error("Gagal memproses POST:", err);
      if (!res.headersSent) {
        sendHtml(res, 500, renderError({
          status: 500,
          title: "Kesalahan Server",
          message: "Terjadi kesalahan saat menyimpan pesan. Coba lagi.",
        }), isHead);
      } else {
        res.end();
      }
    }
    return;
  }

  res.writeHead(405, {
    ...SECURITY_HEADERS,
    Allow: "GET, HEAD, POST",
    "Content-Type": "text/plain; charset=utf-8",
  });
  res.end("405 Method Not Allowed");
});

server.listen(PORT, HOST, () => {
  console.log(`Buku tamu berjalan di http://localhost:${PORT}`);
  console.log(`Database: ${DB_PATH}`);
});

/** Tutup server + database dengan rapi saat dihentikan. */
function shutdown(signal) {
  console.log(`\nMenerima ${signal}, mematikan server...`);
  server.close(() => {
    closeDatabase();
    process.exit(0);
  });
  // Paksa keluar bila koneksi menggantung.
  setTimeout(() => {
    closeDatabase();
    process.exit(0);
  }, 3000).unref();
}

process.on("SIGINT", () => shutdown("SIGINT"));
process.on("SIGTERM", () => shutdown("SIGTERM"));
