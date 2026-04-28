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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

/* CONTAINER */
.container{
    padding:30px;
    max-width:1200px;
    margin:auto;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
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

/* TABLE WRAPPER */
.table-wrapper{
    width:100%;
    overflow-x:auto;
    border-radius:16px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background: rgba(255,255,255,0.05);
    min-width:900px;
}

th{
    background: rgba(255,255,255,0.08);
    padding:14px;
    text-align:left;
    font-size:13px;
}

td{
    padding:14px;
    border-bottom:1px solid rgba(255,255,255,0.05);
    font-size:13px;
}

/* KATEGORI */
.kategori-row td{
    background:#1e293b;
    color:#38bdf8;
    font-weight:bold;
    text-transform:uppercase;
}

/* =========================
   COVER IMAGE
========================= */
.cover-img{
    width:55px;
    height:75px;
    object-fit:cover;
    border-radius:8px;
    box-shadow:0 5px 12px rgba(0,0,0,0.3);
    transition:0.3s;
}

.cover-img:hover{
    transform:scale(1.08);
}

/* BARCODE */
.barcode-img{
    background:white;
    padding:4px;
    border-radius:6px;
    width:120px;
}

/* SMALL TEXT */
small{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:11px;
}

/* ACTION */
.action{
    display:flex;
    gap:6px;
    flex-wrap:wrap;
}

a.action-btn{
    text-decoration:none;
    padding:6px 10px;
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

/* =========================
   TABLET
========================= */
@media (max-width:768px){
    .container{
        padding:18px;
    }

    h2{
        font-size:20px;
    }

    table{
        min-width:700px;
    }
}

/* =========================
   HP / SURFACE / MOBILE
========================= */
@media (max-width:600px){

    table{
        min-width:100%;
    }

    thead{
        display:none;
    }

    table, tbody, tr, td{
        display:block;
        width:100%;
    }

    tr{
        margin-bottom:15px;
        background:rgba(255,255,255,0.05);
        border-radius:12px;
        padding:10px;
    }

    td{
        display:flex;
        justify-content:space-between;
        padding:8px 0;
        border:none;
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    td:last-child{
        border-bottom:none;
    }

    .kategori-row td{
        display:block;
        text-align:center;
    }

    .cover-img{
        width:50px;
        height:70px;
    }

    .action{
        justify-content:flex-end;
        width:100%;
    }
}

/* HP kecil */
@media (max-width:360px){
    h2{
        font-size:18px;
    }

    td{
        font-size:12px;
    }
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

<div class="table-wrapper">

<table>

<tr>
    <th>Barcode</th>
    <th>Cover</th>
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
    <td colspan="6">
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

    <!-- COVER -->
    <td>
        <?php if(!empty($b['cover'])){ ?>
            <img src="../../uploads/<?= $b['cover'] ?>" class="cover-img">
        <?php } else { ?>
            <span style="color:#94a3b8">No Image</span>
        <?php } ?>
    </td>

    <td><?= $b['judul'] ?></td>
    <td><?= $b['penulis'] ?></td>
    <td><?= $b['stok'] ?></td>

    <td>
        <div class="action">
            <a href="edit_buku.php?id=<?= $b['id'] ?>" class="action-btn edit">Edit</a>
            <a href="hapus_buku.php?id=<?= $b['id'] ?>" class="action-btn delete" onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
            <a href="show_buku.php?id=<?= $b['id'] ?>" class="action-btn edit">Show</a>

        </div>
    </td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>