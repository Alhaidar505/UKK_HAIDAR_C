<?php

session_start();
require_once '../../config/koneksi.php';

/* =========================
   VALIDASI ID
========================= */
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

/* =========================
   UPDATE STATUS DENDA
========================= */
$update = mysqli_query($conn, "
    UPDATE peminjaman 
    SET denda_status = 'sudah bayar'
    WHERE id = '$id'
");

/* =========================
   HANDLE RESULT
========================= */
if (!$update) {
    die("❌ Gagal memperbarui status pembayaran");
}

/* =========================
   REDIRECT
========================= */
header("Location: ../dashboard.php");
exit;