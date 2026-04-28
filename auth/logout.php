<?php

session_start();
require_once '../config/koneksi.php';

/* =========================
   LOG ACTIVITY (JIKA LOGIN)
========================= */
if (isset($_SESSION['user'])) {

    $user   = $_SESSION['user'];
    $nama   = $user['nama'] ?? 'Unknown';
    $role   = $user['role'] ?? 'Unknown';

    $aktivitas = "Logout dari sistem";

    $stmt = $conn->prepare("
        INSERT INTO logs (nama_user, aktivitas, role, waktu)
        VALUES (?, ?, ?, NOW())
    ");

    $stmt->bind_param("sss", $nama, $aktivitas, $role);
    $stmt->execute();
    $stmt->close();
}

/* =========================
   DESTROY SESSION
========================= */
session_unset();
session_destroy();

/* =========================
   REDIRECT
========================= */
header("Location: login.php");
exit;