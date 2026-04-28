<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM kategori WHERE id='$id'"));

if(isset($_POST['update'])){
    $nama = $_POST['nama'];

    mysqli_query($conn,"UPDATE kategori SET nama_kategori='$nama' WHERE id='$id'");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Kategori</title>

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
    align-items:center;
    justify-content:center;
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
    box-shadow:0 15px 40px rgba(0,0,0,0.4);
    backdrop-filter:blur(10px);
    transition:0.3s;
}

.container:hover{
    transform:translateY(-3px);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:18px;
    font-size:20px;
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
    font-size:14px;
    margin-bottom:15px;
    transition:0.2s;
}

input:focus{
    background:#111827;
    transform:scale(1.02);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#f59e0b,#f97316);
    color:black;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
    font-size:14px;
}

button:hover{
    transform:scale(1.04);
    box-shadow:0 10px 20px rgba(245,158,11,0.3);
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:14px;
    color:#94a3b8;
    font-size:13px;
    text-decoration:none;
}

.back:hover{
    color:white;
}

/* ======================
   TABLET
====================== */
@media(max-width:768px){
    .container{
        max-width:90%;
        padding:24px;
    }
}

/* ======================
   HP / IPAD MINI
====================== */
@media(max-width:480px){
    .container{
        padding:20px;
        border-radius:14px;
    }

    h2{
        font-size:18px;
    }

    input{
        font-size:13px;
        padding:11px;
    }

    button{
        font-size:13px;
        padding:11px;
    }
}

/* ======================
   HP KECIL
====================== */
@media(max-width:360px){
    h2{
        font-size:16px;
    }
}
</style>

</head>

<body>

<div class="container">

    <h2>✏ Edit Kategori</h2>

    <form method="POST">
        <input type="text" name="nama" value="<?= $data['nama_kategori'] ?>" required>
        <button type="submit" name="update">Update Kategori</button>
    </form>

    <a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>