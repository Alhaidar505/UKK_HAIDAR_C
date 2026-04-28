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

if (!$data) {
    die("Data peminjaman tidak ditemukan");
}

$buku_id = $data['buku_id'];

/* =========================
   VALIDASI BUKU
========================= */
$cek_buku = mysqli_query($conn, "
    SELECT id FROM buku WHERE id='$buku_id' LIMIT 1
");

if (mysqli_num_rows($cek_buku) === 0) {
    die("❌ Buku tidak ditemukan di database");
}

/* =========================
   UPDATE STATUS PEMINJAMAN
========================= */
$update = mysqli_query($conn, "
    UPDATE peminjaman 
    SET status='disetujui'
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
        "Menyetujui peminjaman buku: {$data['judul']} oleh {$data['nama']}"
    );
}

/* =========================
   REDIRECT
========================= */
header("Location: pengajuan.php");
exit;