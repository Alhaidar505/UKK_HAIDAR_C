<?php
include '../../config/koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];

    mysqli_query($conn, "INSERT INTO kategori VALUES(NULL,'$nama')");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Kategori</title>

<style>
body{
    font-family: Arial;
    background:#0f172a;
    margin:0;
    color:white;
}

.container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* CARD */
.card{
    background:#1e293b;
    padding:30px;
    border-radius:12px;
    width:350px;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* TITLE */
.card h2{
    margin-bottom:20px;
    text-align:center;
}

/* INPUT */
input{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #334155;
    background:#0f172a;
    color:white;
    outline:none;
    margin-bottom:15px;
}

input:focus{
    border-color:#38bdf8;
}

/* BUTTON */
button{
    width:100%;
    padding:10px;
    background:#38bdf8;
    border:none;
    border-radius:8px;
    color:black;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#0ea5e9;
    transform:scale(1.02);
}

/* BACK LINK */
.back{
    display:block;
    text-align:center;
    margin-top:10px;
    color:#94a3b8;
    text-decoration:none;
    font-size:13px;
}

.back:hover{
    color:white;
}
</style>

</head>

<body>

<div class="container">

    <div class="card">

        <h2>Tambah Kategori</h2>

        <form method="POST">
            <input type="text" name="nama" placeholder="Nama kategori" required>
            <button type="submit" name="simpan">Simpan</button>
        </form>

        <a href="index.php" class="back">← Kembali</a>

    </div>

</div>

</body>
</html>