<?php
include '../../config/koneksi.php';

$data = mysqli_query($conn, "
SELECT 
    buku.*,
    kategori.nama_kategori
FROM buku
LEFT JOIN kategori ON buku.kategori_id = kategori.id
ORDER BY kategori.nama_kategori ASC, buku.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Buku</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
}

.container{
    padding:40px;
    max-width:1200px;
    margin:auto;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header-left{
    display:flex;
    flex-direction:column;
    gap:6px;
}

h2{
    font-size:26px;
}

/* BUTTON */
.btn-back{
    display:inline-block;
    padding:6px 12px;
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.15);
    color:#cbd5f5;
    text-decoration:none;
    border-radius:8px;
    font-size:12px;
}

.btn-add{
    padding:10px 18px;
    background: linear-gradient(135deg,#38bdf8,#22d3ee);
    color:white;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background: rgba(255,255,255,0.05);
    border-radius:16px;
    overflow:hidden;
}

th{
    background: rgba(255,255,255,0.08);
    padding:16px;
    text-align:left;
}

td{
    padding:16px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

/* KATEGORI HEADER */
.kategori-row td{
    background:#1e293b;
    color:#38bdf8;
    font-weight:bold;
    text-transform:uppercase;
}

/* barcode */
.barcode-img{
    background:white;
    padding:6px;
    border-radius:8px;
}

small{
    display:block;
    margin-top:5px;
    color:#94a3b8;
    font-size:11px;
}

/* aksi */
a.action{
    text-decoration:none;
    margin-right:6px;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
}

.edit{
    background:#38bdf8;
    color:white;
}

.delete{
    background:#ef4444;
    color:white;
}

a.action:hover{
    opacity:0.8;
}
</style>

</head>
<body>

<div class="container">

<div class="header">

    <div class="header-left">
        <a href="../dashboard.php" class="btn-back">← Kembali</a>
        <h2>Data Buku</h2>
    </div>

    <a href="tambah_buku.php" class="btn-add">+ Tambah Buku</a>

</div>

<table>

<tr>
    <th>Barcode</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php
$lastKategori = '';

while($b = mysqli_fetch_assoc($data)) {
?>

<?php if($lastKategori != $b['nama_kategori']) { ?>
<tr class="kategori-row">
    <td colspan="5">
        📚 Kategori: <?= $b['nama_kategori'] ?? 'Tanpa Kategori' ?>
    </td>
</tr>
<?php 
$lastKategori = $b['nama_kategori'];
} ?>

<tr>

    <td>
        <?php if(!empty($b['barcode'])){ ?>
            <img class="barcode-img"
            src="https://barcode.tec-it.com/barcode.ashx?data=<?= $b['barcode'] ?>&code=Code128&dpi=96">
            <small><?= $b['barcode'] ?></small>
        <?php } else { ?>
            <span style="color:#94a3b8">-</span>
        <?php } ?>
    </td>

    <td><?= $b['judul'] ?></td>
    <td><?= $b['penulis'] ?></td>
    <td><?= $b['stok'] ?></td>

    <td>
        <a href="edit_buku.php?id=<?= $b['id'] ?>" class="action edit">Edit</a>
        <a href="hapus_buku.php?id=<?= $b['id'] ?>" class="action delete" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>