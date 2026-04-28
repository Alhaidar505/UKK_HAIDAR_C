<?php

session_start();
require_once '../../config/koneksi.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

/* =========================
   GET ID
========================= */
$id = $_GET['id'] ?? 0;

/* =========================
   QUERY DATA
========================= */
$query = mysqli_query($conn, "
    SELECT peminjaman.*, users.nama, users.username,
           buku.judul, buku.penulis, buku.penerbit, buku.barcode, buku.cover
    FROM peminjaman
    JOIN users ON peminjaman.user_id = users.id
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.id='$id'
    LIMIT 1
");

$trx = mysqli_fetch_assoc($query);

/* =========================
   VALIDASI DATA
========================= */
if (!$trx) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Peminjaman</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:#0f172a;
    color:#fff;
}

/* =========================
   CONTAINER
========================= */
.container{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* =========================
   CARD
========================= */
.card{
    width:100%;
    max-width:450px;
    background:#1e293b;
    border-radius:16px;
    padding:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* =========================
   COVER
========================= */
.cover{
    width:120px;
    height:160px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #334155;
    margin:10px auto;
}

/* =========================
   BARCODE
========================= */
.barcode{
    width:160px;
    background:#fff;
    padding:5px;
    border-radius:8px;
    margin:10px auto;
}

/* =========================
   TEXT
========================= */
h2{
    font-size:18px;
    margin-bottom:10px;
}

p{
    font-size:13px;
    color:#cbd5e1;
    margin:4px 0;
}

hr{
    border:1px solid #334155;
    margin:10px 0;
}

/* =========================
   BUTTON
========================= */
.action{
    display:flex;
    justify-content:center;
    gap:10px;
    margin-top:15px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:0.2s;
}

.back{
    background:#38bdf8;
    color:#000;
}

.print{
    background:#22c55e;
    color:#fff;
}

.btn:hover{
    transform:scale(1.05);
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:768px){
    .card{
        max-width:95%;
    }

    .cover{
        width:110px;
        height:150px;
    }

    .barcode{
        width:150px;
    }
}

@media(max-width:480px){
    h2{font-size:16px}

    .cover{
        width:100px;
        height:140px;
    }

    .barcode{
        width:140px;
    }

    p{font-size:12px}
}

/* =========================
   PRINT MODE
========================= */
@media print{
    body{
        background:#fff;
        color:#000;
    }

    .card{
        background:#fff;
        color:#000;
        box-shadow:none;
    }

    .action{
        display:none;
    }

    p{
        color:#000;
    }
}
</style>

</head>

<body>

<div class="container">

    <div class="card">

        <h2>📄 STRUK PEMINJAMAN</h2>
        <hr>

        <!-- COVER -->
        <?php if (!empty($trx['cover'])) { ?>
            <img class="cover" src="../../uploads/<?= $trx['cover']; ?>" alt="cover">
        <?php } else { ?>
            <div class="cover" style="display:flex;align-items:center;justify-content:center;background:#0f172a;">
                No Cover
            </div>
        <?php } ?>

        <hr>

        <!-- USER -->
        <p><b>Nama:</b> <?= $trx['nama']; ?></p>
        <p><b>Username:</b> <?= $trx['username']; ?></p>

        <hr>

        <!-- BUKU -->
        <p><b>Buku:</b> <?= $trx['judul']; ?></p>
        <p>Penulis: <?= $trx['penulis']; ?></p>
        <p>Penerbit: <?= $trx['penerbit']; ?></p>

        <!-- BARCODE -->
        <img class="barcode"
             src="https://barcode.tec-it.com/barcode.ashx?data=<?= $trx['barcode']; ?>&code=Code128"
             alt="barcode">

        <hr>

        <!-- STATUS -->
        <p>Status: <b><?= strtoupper($trx['status']); ?></b></p>
        <p>Tanggal: <?= $trx['tanggal_pinjam']; ?></p>

        <!-- ACTION -->
        <div class="action">
            <a href="../dashboard.php" class="btn back">← Kembali</a>
            <a href="#" onclick="window.print()" class="btn print">⬇ Download Struk</a>
        </div>

    </div>

</div>

</body>
</html>