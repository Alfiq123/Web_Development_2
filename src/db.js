/**
 * Koneksi database menggunakan modul bawaan Node.js `node:sqlite`.
 * Tidak ada library pihak ketiga yang digunakan.
 */
import { DatabaseSync } from "node:sqlite";
import { mkdirSync, readdirSync, readFileSync } from "node:fs";
import { dirname, join } from "node:path";

/** @type {DatabaseSync | null} */
let db = null;

/**
 * Buka koneksi database, siapkan folder, jalankan semua skema di init.sql/,
 * lalu siapkan prepared statement yang dipakai aplikasi.
 * @param {string} dbPath path file database (mis. ./data/guestbook.db)
 * @param {string} schemaDir folder berisi berkas *.sql
 */
export function openDatabase(dbPath, schemaDir) {
  mkdirSync(dirname(dbPath), { recursive: true });

  db = new DatabaseSync(dbPath);
  db.exec("PRAGMA journal_mode = WAL;");
  db.exec("PRAGMA foreign_keys = ON;");

  runSchema(db, schemaDir);
  return db;
}

/**
 * Eksekusi semua berkas *.sql di folder skema secara idempoten.
 * @param {DatabaseSync} database
 * @param {string} schemaDir
 */
function runSchema(database, schemaDir) {
  const files = readdirSync(schemaDir)
    .filter((name) => name.endsWith(".sql"))
    .sort();

  if (files.length === 0) {
    throw new Error(`Tidak ditemukan berkas .sql di ${schemaDir}`);
  }

  for (const file of files) {
    const sql = readFileSync(join(schemaDir, file), "utf8");
    database.exec(sql);
  }
}

/**
 * Simpan pesan buku tamu baru.
 * @param {{ name: string, body: string }} message
 * @returns {number} id baris yang baru dibuat
 */
export function insertMessage(message) {
  const stmt = database().prepare(
    "INSERT INTO messages (name, body) VALUES (?, ?)"
  );
  const result = stmt.run(message.name, message.body);
  return Number(result.lastInsertRowid);
}

/**
 * Ambil daftar pesan terbaru.
 * @param {number} limit jumlah maksimum pesan
 */
export function listMessages(limit = 100) {
  const stmt = database().prepare(
    `SELECT id, name, body, created_at
       FROM messages
      ORDER BY created_at DESC, id DESC
      LIMIT ?`
  );
  return stmt.all(limit);
}

/** Tutup koneksi database. */
export function closeDatabase() {
  if (db) {
    db.close();
    db = null;
  }
}

/**
 * @returns {DatabaseSync}
 */
function database() {
  if (!db) {
    throw new Error("Database belum dibuka. Panggil openDatabase() dulu.");
  }
  return db;
}
