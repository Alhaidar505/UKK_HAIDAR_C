<?php

session_start();
require_once '../config/koneksi.php';
require_once '../config/logs.php';

/* =========================
   AMBIL INPUT
========================= */
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/* =========================
   VALIDASI INPUT
========================= */
if ($username === '' || $password === '') {
    header("Location: ../auth/login.php?error=empty");
    exit;
}

/* =========================
   AMBIL USER
========================= */
$username = mysqli_real_escape_string($conn, $username);

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE username='$username' LIMIT 1"
);

$user = mysqli_fetch_assoc($query);

/* =========================
   CEK USER
========================= */
if (!$user) {
    header("Location: ../auth/login.php?error=not_found");
    exit;
}

/* =========================
   VALIDASI PASSWORD
========================= */
$passValid = false;

if (password_verify($password, $user['password'])) {
    $passValid = true;
} elseif (md5($password) === $user['password']) {

    // upgrade ke bcrypt
    $newHash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query(
        $conn,
        "UPDATE users SET password='$newHash' WHERE id='{$user['id']}'"
    );

    $passValid = true;
}

/* =========================
   PASSWORD SALAH
========================= */
if (!$passValid) {
    header("Location: ../auth/login.php?error=wrong_password");
    exit;
}

/* =========================
   SET SESSION
========================= */
$_SESSION['user'] = [
    'id'       => $user['id'],
    'nama'     => $user['nama'],
    'username' => $user['username'],
    'role'     => $user['role'],
    'nis'      => $user['nis'] ?? '-',
    'rayon'    => $user['rayon'] ?? '-',
    'alamat'   => $user['alamat'] ?? '-'
];

/* =========================
   LOG LOGIN
========================= */
simpan_log(
    $conn,
    $user['id'],
    $user['nama'],
    $user['role'],
    "Login ke sistem"
);

/* =========================
   REDIRECT BY ROLE
========================= */
$role = $user['role'];

if ($role === 'admin') {
    header("Location: ../admin/dashboard.php");
    exit;
}

if ($role === 'petugas') {
    header("Location: ../petugas/dashboard.php");
    exit;
}

if ($role === 'peminjam') {
    header("Location: ../siswa/dashboard.php");
    exit;
}

/* =========================
   ROLE INVALID
========================= */
session_destroy();
header("Location: ../auth/login.php?error=invalid_role");
exit;