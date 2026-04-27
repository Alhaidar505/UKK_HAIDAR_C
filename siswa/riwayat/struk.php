<?php
include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT peminjaman.*, users.username, users.nis, users.rayon, users.alamat, buku.judul
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.id='$id'
"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Struk Peminjaman</title>

<style>
body{
    font-family:Arial;
    background:#0f172a;
    color:white;
    margin:0;
}

/* WRAPPER */
.wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
}

/* CARD */
.card{
    width:380px;
    background:#1e293b;
    padding:25px;
    border-radius:14px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
    border:1px solid #334155;
}

/* TITLE */
h2{
    margin-top:0;
    margin-bottom:15px;
    letter-spacing:1px;
}

/* INFO */
.info{
    text-align:left;
    font-size:13px;
    margin:6px 0;
    color:#cbd5e1;
}

.info b{
    color:white;
}

/* STATUS */
.status{
    margin-top:12px;
    display:inline-block;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
    text-transform:capitalize;
}

.menunggu{background:#facc15;color:black}
.disetujui{background:#22c55e;color:white}
.ditolak{background:#ef4444;color:white}
.dipinjam{background:#38bdf8;color:white}

/* QR */
.qr{
    margin-top:15px;
}

.qr img{
    width:130px;
    background:white;
    padding:6px;
    border-radius:10px;
}

/* BACK BUTTON */
.back{
    margin-top:20px;
    display:inline-block;
    padding:8px 14px;
    background:#334155;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    transition:0.2s;
}

.back:hover{
    background:#475569;
    transform:translateY(-2px);
}
</style>

</head>

<body>

<div class="wrapper">

<div class="card">

<h2>STRUK PENGAJUAN</h2>

<p class="info"><b>Nama:</b> <?= $data['username']; ?></p>
<p class="info"><b>NIS:</b> <?= $data['nis']; ?></p>
<p class="info"><b>Rayon:</b> <?= $data['rayon']; ?></p>
<p class="info"><b>Alamat:</b> <?= $data['alamat']; ?></p>
<p class="info"><b>Buku:</b> <?= $data['judul']; ?></p>
<p class="info"><b>Tanggal Pinjam:</b> <?= $data['tanggal_pinjam']; ?></p>

<span class="status <?= $data['status']; ?>">
    <?= $data['status']; ?>
</span>

<div class="qr">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=<?= $data['id']; ?>">
</div>

</div>

<!-- BACK BUTTON -->
<a href="../dashboard.php" class="back">← Kembali ke Dashboard</a>

</div>

</body>
</html>