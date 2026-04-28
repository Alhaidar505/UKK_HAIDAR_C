<?php

require_once '../config/koneksi.php';

/* =========================
   VALIDASI ID
========================= */
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan!");
}

/* =========================
   AMBIL DATA
========================= */
$query = mysqli_query($conn, "
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
    LIMIT 1
");

$data = mysqli_fetch_assoc($query);

/* =========================
   VALIDASI DATA
========================= */
if (!$data) {
    die("Data tidak ditemukan!");
}
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
    color:#fff;
}

/* =========================
   WRAPPER
========================= */
.wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* =========================
   CARD
========================= */
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

/* =========================
   INFO TEXT
========================= */
.info{
    text-align:left;
    font-size:13px;
    margin:6px 0;
    color:#cbd5e1;
}

.info b{
    color:#fff;
}

/* =========================
   STATUS
========================= */
.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    margin-top:10px;
}

.menunggu{background:#facc15;color:#000}
.disetujui{background:#22c55e;color:#fff}
.ditolak{background:#ef4444;color:#fff}
.dipinjam{background:#38bdf8;color:#fff}

/* =========================
   QR
========================= */
.qr{
    margin-top:15px;
}

.qr img{
    width:140px;
    background:#fff;
    padding:6px;
    border-radius:10px;
}

/* =========================
   BACK BUTTON
========================= */
.back{
    margin-top:15px;
    display:inline-block;
    padding:8px 12px;
    background:#334155;
    color:#fff;
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

        <!-- QR CODE -->
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=<?= urlencode($data['id']); ?>">
        </div>

        <a href="dashboard.php" class="back">← Kembali</a>

    </div>

</div>

</body>
</html>