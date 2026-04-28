<?php
include '../../config/koneksi.php';

/* 
   AMBIL DATA KATEGORI
 */
$query = mysqli_query($conn, "
    SELECT * FROM kategori
    ORDER BY id DESC
");

$kategori = [];
while($row = mysqli_fetch_assoc($query)){
    $kategori[] = $row;
}

/* 
   HELPER
 */
function e($text){
    return htmlspecialchars($text ?? '');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kategori Buku</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:#0f172a;
    color:white;
}

/* CONTAINER */
.container{
    padding:25px;
    max-width:1000px;
    margin:auto;
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

.header-left{
    display:flex;
    align-items:center;
    gap:12px;
}

h2{
    font-size:20px;
}

/* BUTTON */
.btn-back{
    padding:8px 12px;
    background:#1e293b;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
    border:1px solid #334155;
    transition:0.3s;
}

.btn-back:hover{
    background:#334155;
    transform:translateX(-3px);
}

.btn-add{
    padding:10px 14px;
    background:linear-gradient(135deg,#38bdf8,#22d3ee);
    color:black;
    text-decoration:none;
    border-radius:10px;
    font-weight:600;
    font-size:13px;
}

.btn-add:hover{
    transform:scale(1.05);
}

/* TABLE */
.table-box{
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:14px;
    padding:10px;
    overflow:hidden;
    backdrop-filter:blur(10px);
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:600px;
}

th, td{
    padding:12px;
    text-align:left;
    border-bottom:1px solid rgba(255,255,255,0.08);
    font-size:13px;
}

th{
    color:#94a3b8;
    background:#0b1220;
}

tr:hover{
    background:#111c33;
}

/* ACTION */
a{
    text-decoration:none;
    margin-right:10px;
    font-size:13px;
    transition:0.2s;
}

.edit{ color:#38bdf8; }
.delete{ color:#ef4444; }

.edit:hover,
.delete:hover{
    opacity:0.7;
}

/* RESPONSIVE */
@media(max-width:768px){
    .container{ padding:15px; }
    table{ min-width:100%; }
}

@media(max-width:600px){

    table, thead, tbody, tr, td{
        display:block;
        width:100%;
    }

    thead{ display:none; }

    tr{
        background:#1e293b;
        margin-bottom:15px;
        border-radius:12px;
        padding:12px;
    }

    td{
        display:flex;
        justify-content:space-between;
        padding:8px 0;
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    td:last-child{
        border-bottom:none;
    }

    td::before{
        content:attr(data-label);
        color:#94a3b8;
        font-weight:600;
    }
}
</style>

</head>

<body>

<div class="container">

<!-- HEADER -->
<div class="header">

    <div class="header-left">
        <a href="../dashboard.php" class="btn-back">← Kembali</a>
        <h2>📚 Kategori Buku</h2>
    </div>

    <a href="tambah.php" class="btn-add">+ Tambah Kategori</a>

</div>

<!-- TABLE -->
<div class="table-box">

<table>

<tr>
    <th>No</th>
    <th>Nama Kategori</th>
    <th>Aksi</th>
</tr>

<?php if(count($kategori) > 0): ?>
<?php $no = 1; foreach($kategori as $d): ?>

<tr>
    <td data-label="No"><?= $no++ ?></td>
    <td data-label="Nama"><?= e($d['nama_kategori']) ?></td>
    <td data-label="Aksi">
        <a href="edit.php?id=<?= $d['id'] ?>" class="edit">Edit</a>
        <a href="hapus.php?id=<?= $d['id'] ?>" class="delete" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
    </td>
</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>
    <td colspan="3" style="text-align:center;color:#94a3b8;">
        Tidak ada kategori
    </td>
</tr>

<?php endif; ?>

</table>

</div>

</div>

</body>
</html>