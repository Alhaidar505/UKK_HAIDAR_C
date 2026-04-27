<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

// hapus dulu data peminjaman
mysqli_query($conn, "DELETE FROM peminjaman WHERE user_id='$id'");

// baru hapus user
mysqli_query($conn, "DELETE FROM users WHERE id='$id'");

header("Location: user.php");
exit;