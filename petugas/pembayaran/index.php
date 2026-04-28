<?php

session_start();
require_once '../../config/koneksi.php';
require_once '../../config/logs.php';

/* =========================
   QUERY DATA DENDA
========================= */
$query = mysqli_query($conn, "
    SELECT peminjaman.*, users.nama, buku.judul
    FROM peminjaman
    JOIN users ON peminjaman.user_id = users.id
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.denda > 0
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran Denda</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#0f172a;
    color:#fff;
    padding:20px;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:rgba(255,255,255,0.05);
    border-radius:10px;
    overflow:hidden;
}

th, td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.1);
    text-align:left;
    font-size:14px;
}

th{
    background:rgba(255,255,255,0.08);
}

/* =========================
   BUTTON
========================= */
.btn{
    padding:6px 10px;
    background:#22c55e;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-size:13px;
    display:inline-block;
}

.btn:hover{
    background:#16a34a;
}

/* BACK */
.back{
    display:inline-block;
    margin-top:10px;
    color:#38bdf8;
    text-decoration:none;
}
</style>

</head>

<body>

<h2>💰 Pembayaran Denda Siswa</h2>
<a href="../dashboard.php" class="back">← Kembali</a>

<table>

    <thead>
        <tr>
            <th>Nama</th>
            <th>Buku</th>
            <th>Denda</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>

    <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while ($d = mysqli_fetch_assoc($query)) { ?>

        <tr>
            <td><?= $d['nama'] ?></td>
            <td><?= $d['judul'] ?></td>
            <td>Rp <?= number_format($d['denda'], 0, ',', '.') ?></td>

            <td>
                <?= $d['denda_status'] ?? 'belum bayar' ?>
            </td>

            <td>
                <?php if (($d['denda_status'] ?? '') !== 'lunas') { ?>
                    <a class="btn" href="bayar.php?id=<?= $d['id'] ?>">Bayar</a>
                <?php } else { ?>
                    ✔ Lunas
                <?php } ?>
            </td>
        </tr>

        <?php } ?>
    <?php else: ?>

        <tr>
            <td colspan="5" style="text-align:center; color:#94a3b8;">
                Tidak ada data denda
            </td>
        </tr>

    <?php endif; ?>

    </tbody>

</table>

</body>
</html>