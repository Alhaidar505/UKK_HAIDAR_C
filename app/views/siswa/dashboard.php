<?php
session_start();

// proteksi login
if(!isset($_SESSION['user'])){
    header("Location: /UKK_HAIDAR_C/public");
    exit;
}

// cek role
if($_SESSION['user']['role'] != 'siswa'){
    die("Akses ditolak!");
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#0f172a;
            color:white;
            text-align:center;
            padding:50px;
        }

        .card{
            background:#1e293b;
            padding:30px;
            border-radius:10px;
            display:inline-block;
            box-shadow:0 10px 25px rgba(0,0,0,0.3);
        }

        img{
            margin-top:20px;
        }

        a{
            display:inline-block;
            margin-top:20px;
            padding:10px 20px;
            background:red;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        a:hover{
            background:darkred;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Dashboard Siswa</h1>

    <p><strong>Nama:</strong> <?= $user['nama']; ?></p>
    <p><strong>NIS:</strong> <?= $user['nis']; ?></p>
    <p><strong>Rayon:</strong> <?= $user['rayon']; ?></p>

    <h3>QR / Barcode NIS</h3>

    <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= $user['nis']; ?>&code=Code128" alt="barcode">

    <br>

    <a href="/UKK_HAIDAR_C/public/auth/logout">Logout</a>
</div>

</body>
</html>