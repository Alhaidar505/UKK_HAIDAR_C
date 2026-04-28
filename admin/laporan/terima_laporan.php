<?php
include '../../config/koneksi.php';

/* 
   VALIDASI ID
 */
$id = $_GET['id'] ?? 0;

if(!is_numeric($id)){
    echo "<script>
        alert('ID tidak valid!');
        window.location='index.php';
    </script>";
    exit;
}

/* 
   UPDATE STATUS
 */
$id = (int) $id;

$query = mysqli_query($conn, "
    UPDATE peminjaman 
    SET status='disetujui'
    WHERE id=$id
");

/* 
   RESPONSE
 */
if($query){
    echo "<script>
        alert('Peminjaman berhasil disetujui!');
        window.location='index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menyetujui peminjaman!');
        window.location='index.php';
    </script>";
}
?>