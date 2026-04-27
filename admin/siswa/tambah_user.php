<?php
include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nis      = $_POST['nis'];
    $rayon    = $_POST['rayon'];
    $alamat   = $_POST['alamat'];

    $role = 'peminjam';

    mysqli_query($conn, "
    INSERT INTO users (nama, username, password, nis, rayon, alamat, role)
    VALUES ('$nama','$username','$password','$nis','$rayon','$alamat','$role')
    ");

    echo "<script>
        alert('Siswa berhasil ditambahkan!');
        window.location='user.php';
    </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Siswa</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background: linear-gradient(135deg,#0f172a,#020617);
    color:white;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* CARD */
.container{
    width:400px;
    background:#1e293b;
    padding:30px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,0.5);
    border:1px solid #334155;
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:10px;
    border:none;
    background:#0f172a;
    color:white;
    outline:none;
}

input::placeholder{
    color:#94a3b8;
}

/* BUTTON */
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
    transform:scale(1.03);
}

/* BACK */
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

<input type="text" name="nama" placeholder="Nama Lengkap" required>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="nis" placeholder="NIS" required>
<input type="text" name="rayon" placeholder="Rayon" required>
<input type="text" name="alamat" placeholder="Alamat" required>

<button name="simpan">Simpan</button>

</form>

<a href="user.php" class="back">← Kembali ke Data User</a>

</div>

</body>
</html>