<?php
include '../config/koneksi.php';

$id = $_GET['id'];

/* ambil data peminjaman */
$pinjam = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM peminjaman WHERE id='$id'
"));

$buku_id = $pinjam['buku_id'];

/* update status + tanggal pinjam */
mysqli_query($conn,"
UPDATE peminjaman SET 
status='dipinjam',
tanggal_pinjam=NOW()
WHERE id='$id'
");

/* kurangi stok buku */
mysqli_query($conn,"
UPDATE buku SET 
stok = stok - 1 
WHERE id='$buku_id'
");

echo "<script>
alert('Peminjaman disetujui!');
window.location='dashboard.php';
</script>";
?>