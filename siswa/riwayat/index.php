<?php
session_start();
include '../../config/koneksi.php';

$user_id = $_SESSION['user']['id'];

$data = mysqli_query($conn,"
SELECT peminjaman.*, buku.judul
FROM peminjaman
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.user_id='$user_id'
ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Peminjaman</title>

<style>
body{
    font-family:Arial;
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

.btn-back{
    padding:8px 12px;
    background:#1e293b;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    border:1px solid #334155;
}

/* TABLE */
.table-box{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    border-bottom:1px solid #334155;
    font-size:13px;
}

th{
    color:#94a3b8;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
}

.menunggu{background:#facc15;color:black}
.disetujui{background:#22c55e;color:white}
.ditolak{background:#ef4444;color:white}
.dipinjam{background:#38bdf8;color:white}

/* STRUK BUTTON */
.struk{
    padding:5px 10px;
    background:#38bdf8;
    color:black;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
}
</style>

</head>

<body>

<div class="container">

<div class="header">
    <h2>Riwayat Peminjaman</h2>
    <a href="../dashboard.php" class="btn-back">← Kembali</a>
</div>

<div class="table-box">

<table>
<tr>
    <th>Judul</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($r = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $r['judul']; ?></td>
    <td><?= $r['tanggal_pinjam']; ?></td>

    <td>
        <span class="status <?= $r['status']; ?>">
            <?= $r['status']; ?>
        </span>
    </td>

    <td>
        <a class="struk" href="struk.php?id=<?= $r['id']; ?>">
            Struk
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>

</div>

</body>
</html>