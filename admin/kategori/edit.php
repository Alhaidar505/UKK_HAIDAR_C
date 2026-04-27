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
<html>
<head>
<title>Edit Kategori</title>

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
    text-align:center;
    margin-bottom:20px;
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
    background:#f59e0b;
    border:none;
    border-radius:8px;
    color:black;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#d97706;
    transform:scale(1.02);
}

/* BACK */
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

        <h2>Edit Kategori</h2>

        <form method="POST">
            <input type="text" name="nama" value="<?= $data['nama_kategori'] ?>" required>
            <button type="submit" name="update">Update</button>
        </form>

        <a href="index.php" class="back">← Kembali</a>

    </div>

</div>

</body>
</html>