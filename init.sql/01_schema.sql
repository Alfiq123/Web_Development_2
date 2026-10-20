-- Skema database buku tamu.
-- File-file *.sql di folder ini dibaca dan dieksekusi saat aplikasi mulai (urut abjad).
-- Semua perintah memakai IF NOT EXISTS agar aman dijalankan berulang.

CREATE TABLE IF NOT EXISTS messages (
  id         INTEGER PRIMARY KEY AUTOINCREMENT,
  name       TEXT    NOT NULL,
  body       TEXT    NOT NULL,
  created_at TEXT    NOT NULL DEFAULT (datetime('now'))
);

CREATE INDEX IF NOT EXISTS idx_messages_created
  ON messages(created_at DESC, id DESC);
