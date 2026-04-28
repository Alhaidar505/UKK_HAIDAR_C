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
    SET status='ditolak'
    WHERE id=$id
");

/* 
   RESPONS
 */
if($query){
    echo "<script>
        alert('Pengajuan berhasil ditolak!');
        window.location='index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menolak pengajuan!');
        window.location='index.php';
    </script>";
}
?>