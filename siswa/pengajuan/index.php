<?php
session_start();
include '../../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$buku_id = $_GET['id'];

/* CEK STOK */
$cek = mysqli_query($conn,"SELECT * FROM buku WHERE id='$buku_id'");
$buku = mysqli_fetch_assoc($cek);

if($buku['stok'] <= 0){
    echo "<script>
    alert('Stok buku habis!');
    window.location='../dashboard.php';
    </script>";
    exit;
}

/* PROSES PINJAM */
if(isset($_POST['pinjam'])){

    // INSERT PEMINJAMAN
    mysqli_query($conn,"
    INSERT INTO peminjaman 
    (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status)
    VALUES
    ('$user_id','$buku_id',NOW(),NULL,'menunggu')
    ");

    // KURANGI STOK
    mysqli_query($conn,"
    UPDATE buku 
    SET stok = stok - 1 
    WHERE id='$buku_id'
    ");

    echo "<script>
    alert('Pengajuan berhasil dikirim!');
    window.location='../dashboard.php';
    </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{
    font-family:Arial;
    background:#0f172a;
    color:white;
    margin:0;
}

.container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    background:#1e293b;
    padding:25px;
    border-radius:12px;
    width:350px;
    text-align:center;
}

button{
    width:100%;
    padding:10px;
    background:#38bdf8;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    opacity:0.8;
}
</style>

</head>

<body>

<div class="container">
<div class="card">

<h2>Ajukan Peminjaman</h2>

<p><b><?= $buku['judul']; ?></b></p>
<p>Stok tersisa: <?= $buku['stok']; ?></p>

<form method="POST">
    <button type="submit" name="pinjam">
        Ajukan Pinjam
    </button>
</form>

</div>
</div>

</body>
</html>