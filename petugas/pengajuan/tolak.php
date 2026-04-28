<?php

session_start();
require_once '../../config/koneksi.php';
require_once '../../config/logs.php';

/* =========================
   VALIDASI ID
========================= */
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan");
}

/* =========================
   AMBIL DATA PEMINJAMAN
========================= */
$query = mysqli_query($conn, "
    SELECT peminjaman.*, users.nama, buku.judul
    FROM peminjaman
    LEFT JOIN users ON peminjaman.user_id = users.id
    LEFT JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.id='$id'
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);

/* =========================
   VALIDASI DATA
========================= */
if (!$data) {
    die("❌ Data peminjaman tidak ditemukan!");
}

/* =========================
   UPDATE STATUS (DITOLAK)
========================= */
$update = mysqli_query($conn, "
    UPDATE peminjaman 
    SET status='ditolak'
    WHERE id='$id'
");

/* =========================
   LOG AKTIVITAS
========================= */
if ($update) {
    simpan_log(
        $conn,
        $_SESSION['user']['id'] ?? 0,
        $_SESSION['user']['nama'] ?? '-',
        $_SESSION['user']['role'] ?? '-',
        "Menolak peminjaman buku: {$data['judul']} oleh {$data['nama']}"
    );
}

/* =========================
   REDIRECT
========================= */
header("Location: pengajuan.php");
exit;