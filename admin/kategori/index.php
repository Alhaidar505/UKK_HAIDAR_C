<?php
include '../../config/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Kategori Buku</title>

<style>
body{
    font-family: Arial;
    background:#0f172a;
    color:white;
    margin:0;
}

.container{
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

/* LEFT HEADER */
.header-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.header h2{
    margin:0;
}

/* BACK BUTTON */
.btn-back{
    padding:8px 12px;
    background:#1e293b;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    border:1px solid #334155;
    transition:0.3s;
}

.btn-back:hover{
    background:#334155;
    transform:translateX(-3px);
}

/* ADD BUTTON */
.btn-add{
    padding:10px 15px;
    background:#38bdf8;
    color:black;
    text-decoration:none;
    border-radius:8px;
    font-size:14px;
    font-weight:bold;
}

.btn-add:hover{
    background:#0ea5e9;
}

/* TABLE CARD */
.table-box{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    border-bottom:1px solid #334155;
    text-align:left;
}

th{
    color:#94a3b8;
    font-size:13px;
}

/* ACTION */
a{
    text-decoration:none;
    margin-right:10px;
    font-size:13px;
}

.edit{
    color:#38bdf8;
}

.delete{
    color:#ef4444;
}

.delete:hover{
    text-decoration:underline;
}
</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div class="header-left">
            <a href="../dashboard.php" class="btn-back">← Kembali</a>
            <h2>Kategori Buku</h2>
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

            <?php $no=1; while($d = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama_kategori'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $d['id'] ?>" class="edit">Edit</a>
                    <a href="hapus.php?id=<?= $d['id'] ?>" class="delete" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>