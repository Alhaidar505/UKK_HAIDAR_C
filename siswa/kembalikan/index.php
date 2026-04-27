<?php
session_start();
include '../../config/koneksi.php';

$id = $_GET['id'];

/* ambil data peminjaman */
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM peminjaman WHERE id='$id'
"));

$buku_id = $data['buku_id'];

/* update peminjaman */
mysqli_query($conn,"
UPDATE peminjaman SET 
status='dikembalikan',
tanggal_kembali=NOW()
WHERE id='$id'
");

/* tambah stok buku */
mysqli_query($conn,"
UPDATE buku SET 
stok = stok + 1
WHERE id='$buku_id'
");

echo "<script>
alert('Buku berhasil dikembalikan!');
window.location='../dashboard.php';
</script>";
?>