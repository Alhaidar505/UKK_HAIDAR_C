<?php
session_start();
include '../../config/koneksi.php';
include '../../config/logs.php';

// ambil id
$id = $_GET['id'];

// ambil data buku dulu (untuk logs)
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id='$id'");
$buku = mysqli_fetch_assoc($data);

// hapus data
$delete = mysqli_query($conn, "DELETE FROM buku WHERE id='$id'");

// simpan logs jika berhasil
if($delete && $buku){
    simpan_log(
        $conn,
        $_SESSION['user']['id'],
        $_SESSION['user']['nama'],
        $_SESSION['user']['role'],
        "Menghapus buku: ".$buku['judul']." (ID: $id)"
    );
}

header("Location: index.php");
exit;
?>