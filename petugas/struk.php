<?php
include '../config/koneksi.php';

/* VALIDASI ID */
if(!isset($_GET['id'])){
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT 
peminjaman.*,
users.username,
users.nis,
users.rayon,
users.alamat,
buku.judul
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.id='$id'
"));
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Struk Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:380px;
    background:#1e293b;
    padding:20px;
    border-radius:14px;
    text-align:center;
    border:1px solid #334155;
}

h2{
    margin-bottom:15px;
}

.info{
    text-align:left;
    font-size:13px;
    margin:6px 0;
    color:#cbd5e1;
}

.info b{
    color:white;
}

.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    margin-top:10px;
}

.menunggu{background:#facc15;color:black}
.disetujui{background:#22c55e}
.ditolak{background:#ef4444}
.dipinjam{background:#38bdf8}

.qr{
    margin-top:15px;
}

.qr img{
    width:140px;
    background:white;
    padding:6px;
    border-radius:10px;
}

.back{
    margin-top:15px;
    display:inline-block;
    padding:8px 12px;
    background:#334155;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
}
</style>

</head>

<body>

<div class="wrapper">

<div class="card">

<h2>📄 STRUK PEMINJAMAN</h2>

<p class="info"><b>Nama:</b> <?= $data['username']; ?></p>
<p class="info"><b>NIS:</b> <?= $data['nis']; ?></p>
<p class="info"><b>Rayon:</b> <?= $data['rayon']; ?></p>
<p class="info"><b>Alamat:</b> <?= $data['alamat']; ?></p>
<p class="info"><b>Buku:</b> <?= $data['judul']; ?></p>
<p class="info"><b>Tanggal:</b> <?= $data['tanggal_pinjam']; ?></p>

<span class="status <?= $data['status']; ?>">
    <?= strtoupper($data['status']); ?>
</span>

<!-- QR -->
<div class="qr">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=<?= urlencode($data['id']); ?>">
</div>

<a href="dashboard.php" class="back">← Kembali</a>

</div>

</div>

</body>
</html>