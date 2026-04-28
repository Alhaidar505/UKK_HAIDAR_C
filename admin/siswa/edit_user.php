<?php
session_start();
include '../../config/koneksi.php';

/*  HELPER FUNCTION */
function sanitize($data){
    return htmlspecialchars($data ?? '');
}

/* VALIDASI ID */
$id = $_GET['id'] ?? 0;
$id = intval($id);

if($id <= 0){
    header("Location: user.php");
    exit;
}

/* AMBIL DATA USER */
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
$user  = mysqli_fetch_assoc($query);

if(!$user){
    echo "<script>alert('Data tidak ditemukan');window.location='data_siswa.php';</script>";
    exit;
}

/* PROSES UPDATE */
if(isset($_POST['update'])){

    $nama     = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $nis      = trim($_POST['nis'] ?? '');
    $rayon    = trim($_POST['rayon'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');

    // validasi 
    if($nama === '' || $username === ''){
        echo "<script>alert('Nama & Username wajib diisi!');</script>";
    } else {

        // escape untuk query
        $nama     = mysqli_real_escape_string($conn, $nama);
        $username = mysqli_real_escape_string($conn, $username);
        $nis      = mysqli_real_escape_string($conn, $nis);
        $rayon    = mysqli_real_escape_string($conn, $rayon);
        $alamat   = mysqli_real_escape_string($conn, $alamat);

        $update = mysqli_query($conn, "
            UPDATE users SET
                nama     = '$nama',
                username = '$username',
                nis      = '$nis',
                rayon    = '$rayon',
                alamat   = '$alamat'
            WHERE id = '$id'
        ");

        if($update){
            echo "<script>
                alert('Data berhasil diupdate!');
                window.location='user.php';
            </script>";
        } else {
            echo "<script>alert('Gagal update data!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Siswa</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}

body{
    background:#0f172a;
    color:white;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.container{
    width:100%;
    max-width:520px;
    background:#1e293b;
    padding:26px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

h2{
    text-align:center;
    margin-bottom:16px;
}

/* INPUT */
.input-group{margin-bottom:12px;}

input, textarea{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:rgba(255,255,255,0.1);
    color:white;
    outline:none;
}

textarea{
    resize:none;
    min-height:80px;
}

/* BUTTON */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:14px;
    cursor:pointer;
    transition:0.3s;
    text-align:center;
    display:block;
    text-decoration:none;
}

.btn-save{
    background:#22c55e;
    color:white;
}

.btn-save:hover{
    background:#16a34a;
}

.btn-back{
    margin-top:10px;
    background:rgba(255,255,255,0.1);
    color:white;
}

@media(max-width:480px){
    .container{ padding:18px; }
    input, textarea{ font-size:13px; }
}
</style>
</head>

<body>

<div class="container">

<h2>Edit Data Siswa</h2>

<form method="POST">

<div class="input-group">
<input type="text" name="nama" value="<?= sanitize($user['nama']) ?>" required>
</div>

<div class="input-group">
<input type="text" name="username" value="<?= sanitize($user['username']) ?>" required>
</div>

<div class="input-group">
<input type="text" name="nis" value="<?= sanitize($user['nis']) ?>">
</div>

<div class="input-group">
<input type="text" name="rayon" value="<?= sanitize($user['rayon']) ?>">
</div>

<div class="input-group">
<textarea name="alamat"><?= sanitize($user['alamat']) ?></textarea>
</div>

<button type="submit" name="update" class="btn btn-save">
💾 Simpan Perubahan
</button>

<a href="user.php" class="btn btn-back">← Kembali</a>

</form>

</div>

</body>
</html>