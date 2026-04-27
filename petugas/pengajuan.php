<?php
include '../config/koneksi.php';

$data = mysqli_query($conn,"
SELECT peminjaman.*, users.username, buku.judul
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.status='menunggu'
ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Pengajuan Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.container{padding:30px;}

table{
    width:100%;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th,td{
    padding:12px;
    border-bottom:1px solid #334155;
    font-size:13px;
}

th{
    background:#0b1220;
    color:#94a3b8;
}

.btn{
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:12px;
}

.terima{background:#22c55e;color:white}
.tolak{background:#ef4444;color:white}

.back{
    display:inline-block;
    margin-bottom:15px;
    color:#38bdf8;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="container">

<a href="dashboard.php" class="back">← Kembali</a>

<h2>📥 Pengajuan Peminjaman</h2>

<table>
<tr>
    <th>User</th>
    <th>Buku</th>
    <th>Aksi</th>
</tr>

<?php while($d = mysqli_fetch_assoc($data)) { ?>

<tr>
    <td><?= $d['username'] ?></td>
    <td><?= $d['judul'] ?></td>

    <td>
        <a class="btn terima" href="terima.php?id=<?= $d['id'] ?>">Setujui</a>
        <a class="btn tolak" href="tolak.php?id=<?= $d['id'] ?>">Tolak</a>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>