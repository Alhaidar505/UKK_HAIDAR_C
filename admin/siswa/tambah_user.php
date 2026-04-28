<?php
session_start();
include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $nis      = mysqli_real_escape_string($conn, trim($_POST['nis']));
    $rayon    = mysqli_real_escape_string($conn, $_POST['rayon']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);

    $role = 'peminjam';

    /* 
       VALIDASI
     */

    // username tidak boleh spasi
    if (strpos($username, ' ') !== false) {
        echo "<script>alert('Username tidak boleh mengandung spasi!');</script>";
        exit;
    }

    // username unik
    $cek_username = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    if(mysqli_num_rows($cek_username) > 0){
        echo "<script>alert('Username sudah digunakan!');</script>";
        exit;
    }

    // nis unik
    $cek_nis = mysqli_query($conn, "SELECT id FROM users WHERE nis='$nis'");
    if(mysqli_num_rows($cek_nis) > 0){
        echo "<script>alert('NIS sudah terdaftar!');</script>";
        exit;
    }

    // nama unik
    $cek_nama = mysqli_query($conn, "SELECT id FROM users WHERE nama='$nama'");
    if(mysqli_num_rows($cek_nama) > 0){
        echo "<script>alert('Nama sudah digunakan!');</script>";
        exit;
    }

    // password hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // insert data
    $query = mysqli_query($conn, "
        INSERT INTO users 
        (nama, username, password, nis, rayon, alamat, role)
        VALUES 
        ('$nama','$username','$password_hash','$nis','$rayon','$alamat','$role')
    ");

    if($query){
        echo "<script>
            alert('Siswa berhasil ditambahkan!');
            window.location='user.php';
        </script>";
    } else {
        echo "<script>alert('Gagal menyimpan data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Siswa</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#0f172a,#020617);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    color:white;
}

.container{
    width:100%;
    max-width:420px;
    background:rgba(30,41,59,0.95);
    padding:26px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,0.5);
    border:1px solid rgba(255,255,255,0.08);
}

h2{
    text-align:center;
    margin-bottom:15px;
}

.input-group{
    margin-top:10px;
}

input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    background:#0f172a;
    color:white;
    outline:none;
    font-size:14px;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    background:#22c55e;
    border:none;
    border-radius:10px;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#16a34a;
}

.back{
    display:block;
    margin-top:15px;
    text-align:center;
    color:#38bdf8;
    text-decoration:none;
    font-size:13px;
}

.back:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="container">

<h2>Tambah Siswa</h2>

<form method="POST">

<div class="input-group">
<input type="text" name="nama" placeholder="Nama Lengkap" required>
</div>

<div class="input-group">
<input type="text" name="username" placeholder="Username (tanpa spasi)" required>
</div>

<div class="input-group">
<input type="password" name="password" placeholder="Password" required>
</div>

<div class="input-group">
<input type="text" name="nis" placeholder="NIS" required>
</div>

<div class="input-group">
<input type="text" name="rayon" placeholder="Rayon" required>
</div>

<div class="input-group">
<input type="text" name="alamat" placeholder="Alamat" required>
</div>

<button type="submit" name="simpan">Simpan</button>

</form>

<a href="user.php" class="back">← Kembali ke Data Siswa</a>

</div>

</body>
</html>