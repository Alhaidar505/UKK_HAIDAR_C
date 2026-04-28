<?php
include '../../config/koneksi.php';

/* =========================
   PROSES SIMPAN KATEGORI
========================= */
if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);

    if (!empty($nama)) {

        $nama_safe = mysqli_real_escape_string($conn, $nama);

        $query = mysqli_query($conn, "
            INSERT INTO kategori (nama_kategori)
            VALUES ('$nama_safe')
        ");

        if ($query) {
            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Gagal menambahkan kategori');</script>";
        }

    } else {
        echo "<script>alert('Nama kategori wajib diisi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Kategori</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:linear-gradient(135deg,#0f172a,#020617);
    color:white;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.container{
    width:100%;
    max-width:420px;
    background:rgba(30,41,59,0.85);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:28px;
    backdrop-filter:blur(10px);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:18px;
}

/* INPUT */
input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    outline:none;
    background:#0f172a;
    color:white;
    margin-bottom:15px;
}

input::placeholder{
    color:#94a3b8;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#38bdf8,#0ea5e9);
    color:black;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:14px;
    color:#94a3b8;
    text-decoration:none;
    font-size:13px;
}

.back:hover{
    color:white;
}

/* RESPONSIVE */
@media(max-width:480px){
    .container{
        padding:20px;
    }

    h2{
        font-size:18px;
    }

    input, button{
        font-size:13px;
        padding:11px;
    }
}
</style>

</head>

<body>

<div class="container">

    <h2>Tambah Kategori</h2>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama kategori..." required>
        <button type="submit" name="simpan">Simpan Kategori</button>
    </form>

    <a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>