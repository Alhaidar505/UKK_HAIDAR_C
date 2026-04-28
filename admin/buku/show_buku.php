<?php
include '../../config/koneksi.php';

$id = $_GET['id'] ?? 0;

$data = mysqli_query($conn, "
SELECT 
    buku.*,
    kategori.nama_kategori
FROM buku
LEFT JOIN kategori ON buku.kategori_id = kategori.id
WHERE buku.id='$id'
");

$b = mysqli_fetch_assoc($data);

if(!$b){
    echo "<script>alert('Data tidak ditemukan');window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Buku</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

/* CARD */
.card{
    width:100%;
    max-width:850px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:16px;
    padding:25px;
    backdrop-filter:blur(10px);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
    gap:10px;
}

.back{
    padding:8px 12px;
    border-radius:8px;
    background:rgba(255,255,255,0.08);
    color:white;
    text-decoration:none;
    font-size:13px;
}

/* CONTENT */
.wrapper{
    display:grid;
    grid-template-columns:200px 1fr;
    gap:20px;
}

/* COVER */
.cover{
    width:100%;
    height:260px;
    border-radius:12px;
    overflow:hidden;
    background:#0b1220;
    display:flex;
    align-items:center;
    justify-content:center;
}

.cover img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* INFO */
.info h2{
    margin-bottom:10px;
}

.info p{
    margin-bottom:8px;
    color:#cbd5f5;
    font-size:14px;
}

.badge{
    display:inline-block;
    padding:4px 10px;
    border-radius:20px;
    background:#38bdf8;
    color:black;
    font-size:12px;
    margin-bottom:10px;
}

/* BARCODE */
.barcode{
    margin-top:15px;
    background:white;
    padding:6px;
    display:inline-block;
    border-radius:8px;
}

.barcode img{
    width:180px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .wrapper{
        grid-template-columns:1fr;
    }

    .cover{
        height:220px;
    }
}

@media(max-width:480px){
    .card{
        padding:18px;
    }

    .barcode img{
        width:140px;
    }
}
</style>

</head>

<body>

<div class="card">

    <div class="header">
        <h2>📚 Detail Buku</h2>
        <a href="index.php" class="back">← Kembali</a>
    </div>

    <div class="wrapper">

        <!-- COVER -->
        <div class="cover">
            <?php if(!empty($b['cover'])){ ?>
                <img src="../../uploads/<?= $b['cover'] ?>" alt="cover">
            <?php } else { ?>
                <span style="color:#94a3b8">Tidak ada cover</span>
            <?php } ?>
        </div>

        <!-- INFO -->
        <div class="info">

            <span class="badge"><?= $b['nama_kategori'] ?? 'Tanpa Kategori' ?></span>

            <h2><?= $b['judul'] ?></h2>

            <p><b>Penulis:</b> <?= $b['penulis'] ?></p>
            <p><b>Penerbit:</b> <?= $b['penerbit'] ?></p>
            <p><b>Tahun:</b> <?= $b['tahun'] ?></p>
            <p><b>Stok:</b> <?= $b['stok'] ?></p>
            <p><b>Harga:</b> Rp <?= number_format($b['harga'],0,',','.') ?></p>
            <p><b>Barcode:</b> <?= $b['barcode'] ?></p>

            <!-- BARCODE -->
            <div class="barcode">
                <img src="https://barcode.tec-it.com/barcode.ashx?data=<?= $b['barcode'] ?>&code=Code128&dpi=96">
            </div>

        </div>

    </div>

</div>

</body>
</html>