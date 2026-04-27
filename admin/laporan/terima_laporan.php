<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

/* ubah status jadi disetujui */
mysqli_query($conn,"
UPDATE peminjaman 
SET status='disetujui'
WHERE id='$id'
");

echo "<script>
alert('Peminjaman disetujui!');
window.location='index.php';
</script>";
?>