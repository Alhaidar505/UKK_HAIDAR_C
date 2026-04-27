<?php
include '../../config/koneksi.php';

/* =========================
   AMBIL DATA PENGAJUAN (A-Z USERNAME)
========================= */
$data = mysqli_query($conn, "
SELECT 
    peminjaman.id AS id_pinjam,
    users.username,
    buku.judul,
    kategori.nama_kategori,
    peminjaman.tanggal_pinjam,
    peminjaman.tanggal_kembali,
    peminjaman.status,
    peminjaman.catatan
FROM peminjaman
LEFT JOIN users ON peminjaman.user_id = users.id
LEFT JOIN buku ON peminjaman.buku_id = buku.id
LEFT JOIN kategori ON buku.kategori_id = kategori.id
ORDER BY users.username ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Laporan Pengajuan Peminjaman</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#0f172a;
    color:white;
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

.header h2{
    margin:0;
}

/* BACK BUTTON */
.back{
    padding:8px 14px;
    background:#1e293b;
    border:1px solid #334155;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
}

.back:hover{
    background:#334155;
}

/* CARD */
.card{
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid #334155;
    text-align:left;
}

th{
    background:#0b1220;
    color:#94a3b8;
}

/* HOVER */
tr:hover{
    background:#111c33;
}

/* STATUS */
.status{
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    display:inline-block;
    text-transform:capitalize;
}

.menunggu{background:#facc15;color:black}
.disetujui{background:#22c55e;color:white}
.ditolak{background:#ef4444;color:white}

/* BUTTON */
.btn{
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:12px;
    margin-right:5px;
    display:inline-block;
}

.accept{background:#22c55e;color:white}
.reject{background:#ef4444;color:white}

/* EMPTY */
.empty{
    color:#94a3b8;
}
</style>

</head>

<body>

<div class="container">

<div class="header">
    <h2>📊 Laporan Pengajuan Peminjaman (A-Z)</h2>
    <a href="../dashboard.php" class="back">← Kembali</a>
</div>

<div class="card">

<table>

<tr>
    <th>ID</th>
    <th>User</th>
    <th>Buku</th>
    <th>Kategori</th>
    <th>Tanggal Pinjam</th>
    <th>Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($d = mysqli_fetch_assoc($data)) { ?>

<tr>
    <td>#<?= $d['id_pinjam'] ?></td>
    <td><?= $d['username'] ?></td>
    <td><?= $d['judul'] ?></td>
    <td><?= $d['nama_kategori'] ?></td>
    <td><?= $d['tanggal_pinjam'] ?></td>
    <td><?= $d['tanggal_kembali'] ?? '-' ?></td>

    <td>
        <span class="status <?= $d['status'] ?>">
            <?= $d['status'] ?>
        </span>
    </td>

    <td>
        <?php if($d['status'] == 'menunggu'){ ?>
            <a href="terima_laporan.php?id=<?= $d['id_pinjam'] ?>" class="btn accept">Terima</a>
            <a href="tolak_laporan.php?id=<?= $d['id_pinjam'] ?>" class="btn reject">Tolak</a>
        <?php } else { ?>
            <span class="empty">Selesai</span>
        <?php } ?>
    </td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>