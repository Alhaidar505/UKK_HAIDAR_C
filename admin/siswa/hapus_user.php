<?php
include '../../config/koneksi.php';

// VALIDASI ID

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$id = intval($_GET['id']); // amankan input

// HAPUS DATA TERKAIT
         
// hapus peminjaman dulu
$hapus_peminjaman = mysqli_query($conn, "
    DELETE FROM peminjaman 
    WHERE user_id = '$id'
");

// cek error
if(!$hapus_peminjaman){
    die("Gagal menghapus data peminjaman: " . mysqli_error($conn));
}

// HAPUS USER
$hapus_user = mysqli_query($conn, "
    DELETE FROM users 
    WHERE id = '$id'
");

// cek error
if(!$hapus_user){
    die("Gagal menghapus user: " . mysqli_error($conn));
}

// REDIRECT

header("Location: user.php");
exit;
?>