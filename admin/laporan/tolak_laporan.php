<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE peminjaman 
SET status='ditolak'
WHERE id='$id'
");

echo "<script>
alert('Pengajuan ditolak!');
window.location='index.php';
</script>";
?>