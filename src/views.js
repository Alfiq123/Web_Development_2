/**
 * Render HTML buku tamu (server-side rendering, tanpa framework template).
 * Semua data pengguna wajib melewati escapeHtml() sebelum dimasukkan ke markup.
 */

const MAX_NAME_LENGTH = 50;
const MAX_BODY_LENGTH = 500;

export const LIMITS = {
  MAX_NAME_LENGTH,
  MAX_BODY_LENGTH,
  MAX_BODY_BYTES: 16 * 1024, // 16 KB
  LIST_LIMIT: 100,
};

/**
 * Escape karakter yang berbahaya bila disisipkan ke dalam HTML.
 * @param {unknown} value
 * @returns {string}
 */
export function escapeHtml(value) {
  return String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#39;");
}

const STYLES = `
    * { box-sizing: border-box; }
    body {
      margin: 0;
      padding: 40px 16px;
      min-height: 100vh;
      background: #f5f5f5;
      color: #222;
      font-family: system-ui, -apple-system, sans-serif;
    }
    main { width: 100%; max-width: 560px; margin: 0 auto; }
    .card {
      background: #fff;
      padding: 28px;
      border: 1px solid #e5e5e5;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    h1 { font-size: 20px; font-weight: 600; margin: 0 0 4px; }
    p.sub { font-size: 13px; color: #777; margin: 0 0 20px; }
    label { display: block; font-size: 14px; margin-bottom: 4px; }
    input[type="text"], textarea {
      width: 100%;
      padding: 9px 10px;
      font: inherit;
      font-size: 14px;
      border: 1px solid #d5d5d5;
      border-radius: 6px;
      background: #fff;
      color: #222;
    }
    input[type="text"]:focus, textarea:focus {
      outline: none;
      border-color: #555;
    }
    textarea { min-height: 110px; resize: vertical; }
    .field { margin-bottom: 16px; }
    .hint { font-size: 12px; color: #888; margin-top: 4px; }
    button {
      display: inline-block;
      padding: 10px 18px;
      font: inherit;
      font-size: 14px;
      font-weight: 600;
      color: #fff;
      background: #111;
      border: 0;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover { background: #333; }
    .error {
      background: #fdf1f1;
      border: 1px solid #f0c8c8;
      color: #a12626;
      padding: 10px 12px;
      border-radius: 6px;
      font-size: 13px;
      margin-bottom: 16px;
    }
    .empty {
      font-size: 14px;
      color: #777;
      text-align: center;
      padding: 24px 0;
    }
    article.message { padding: 16px 0; border-top: 1px solid #eee; }
    article.message:first-of-type { border-top: 0; padding-top: 0; }
    .message-head {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 6px;
    }
    .message-name { font-size: 14px; font-weight: 600; }
    .message-date { font-size: 12px; color: #999; white-space: nowrap; }
    .message-body { font-size: 14px; line-height: 1.55; color: #333; margin: 0; white-space: pre-wrap; word-break: break-word; }
    h2 { font-size: 16px; font-weight: 600; margin: 0 0 16px; }
    footer { text-align: center; font-size: 12px; color: #999; }
`;

/**
 * Layout dasar halaman.
 * @param {{ title: string, body: string }} options
 */
function layout({ title, body }) {
  return `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'none'; style-src 'unsafe-inline'; form-action 'self'; base-uri 'none'">
    <title>${escapeHtml(title)}</title>
    <style>${STYLES}</style>
</head>
<body>
    <main>
${body}
    </main>
</body>
</html>
`;
}

/**
 * Render halaman utama: form buku tamu + daftar pesan.
 * @param {{ messages: Array<{id:number,name:string,body:string,created_at:string}>, values?: {name?:string,body?:string}, error?: string|null, notice?: string|null }} options
 */
export function renderHome({ messages, values = {}, error = null, notice = null }) {
  const nameValue = escapeHtml(values.name ?? "");
  const bodyValue = escapeHtml(values.body ?? "");
  const nameCount = (values.name ?? "").length;
  const bodyCount = (values.body ?? "").length;

  const errorBox = error
    ? `      <p class="error" role="alert">${escapeHtml(error)}</p>\n`
    : "";
  const noticeBox = notice
    ? `      <p class="hint" role="status">${escapeHtml(notice)}</p>\n`
    : "";

  const form = `      <section class="card">
        <h1>Buku Tamu</h1>
        <p class="sub">Tinggalkan pesan untuk pengunjung lainnya.</p>
${noticeBox}${errorBox}        <form method="post" action="/" novalidate>
          <div class="field">
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" maxlength="${MAX_NAME_LENGTH}" required value="${nameValue}" placeholder="Nama Anda">
            <p class="hint">${nameCount}/${MAX_NAME_LENGTH} karakter</p>
          </div>
          <div class="field">
            <label for="body">Pesan</label>
            <textarea id="body" name="body" maxlength="${MAX_BODY_LENGTH}" required placeholder="Tulis pesan Anda...">${bodyValue}</textarea>
            <p class="hint">${bodyCount}/${MAX_BODY_LENGTH} karakter</p>
          </div>
          <button type="submit">Kirim Pesan</button>
        </form>
      </section>`;

  const list =
    messages.length === 0
      ? `      <p class="empty">Belum ada pesan. Jadilah yang pertama!</p>`
      : messages
          .map(
            (m) => `      <article class="message">
        <div class="message-head">
          <span class="message-name">${escapeHtml(m.name)}</span>
          <time class="message-date" datetime="${escapeHtml(m.created_at)}">${escapeHtml(m.created_at)} UTC</time>
        </div>
        <p class="message-body">${escapeHtml(m.body)}</p>
      </article>`
          )
          .join("\n");

  const body = `${form}
      <section class="card">
        <h2>Pesan Terbaru</h2>
${list}
      </section>
      <footer>Buku tamu &middot; Node.js tanpa framework</footer>`;

  return layout({ title: "Buku Tamu", body });
}

/**
 * Render halaman galat (404/405/400/413).
 * @param {{ status: number, title: string, message: string }} options
 */
export function renderError({ status, title, message }) {
  const body = `      <section class="card">
        <h1>${escapeHtml(title)}</h1>
        <p class="sub">${escapeHtml(message)}</p>
        <form method="get" action="/">
          <button type="submit">Kembali ke beranda</button>
        </form>
      </section>`;

  return layout({ title: `${status} ${title}`, body });
}
