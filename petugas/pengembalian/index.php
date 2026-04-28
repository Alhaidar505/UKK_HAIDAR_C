<?php

require_once '../../config/koneksi.php';

/* =========================
   QUERY DATA
========================= */
$query = mysqli_query($conn, "
    SELECT 
        p.id,
        u.nama,
        b.judul,
        p.tanggal_pinjam,
        p.tanggal_kembali_rencana,
        p.status,
        p.denda
    FROM peminjaman p
    JOIN users u ON p.user_id = u.id
    JOIN buku b ON p.buku_id = b.id
    WHERE p.status = 'menunggu_kembali'
    ORDER BY p.id DESC
");

/* =========================
   ESCAPE FUNCTION
========================= */
function e($text)
{
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pengembalian Buku</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:#fff;
}

/* =========================
   CONTAINER
========================= */
.container{
    padding:20px;
    max-width:1100px;
    margin:auto;
}

/* =========================
   HEADER
========================= */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

/* BACK BUTTON */
.back{
    padding:8px 12px;
    background:#1e293b;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    border:1px solid #334155;
}

.back:hover{
    background:#334155;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th, td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid #334155;
}

th{
    background:#0b1220;
    color:#94a3b8;
    text-align:left;
}

tr:hover{
    background:#111c33;
}

/* =========================
   BUTTONS
========================= */
.btn{
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:12px;
    display:inline-block;
    margin-right:5px;
}

.btn-accept{
    background:#22c55e;
    color:#fff;
}

.btn-reject{
    background:#ef4444;
    color:#fff;
}

/* =========================
   STATUS
========================= */
.status{
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
    background:#f59e0b;
    color:#000;
}

/* =========================
   EMPTY STATE
========================= */
.empty{
    text-align:center;
    padding:20px;
    color:#94a3b8;
}
</style>

</head>

<body>

<div class="container">

    <div class="header">
        <h2>📦 Pengajuan Pengembalian</h2>
        <a href="../dashboard.php" class="back">← Kembali</a>
    </div>

    <table>

        <thead>
            <tr>
                <th>Nama</th>
                <th>Buku</th>
                <th>Pinjam</th>
                <th>Kembali Rencana</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($d = mysqli_fetch_assoc($query)) { ?>

            <tr>
                <td><?= e($d['nama']) ?></td>
                <td><?= e($d['judul']) ?></td>
                <td><?= e($d['tanggal_pinjam']) ?></td>
                <td><?= e($d['tanggal_kembali_rencana']) ?></td>

                <td>
                    <b style="color:<?= ($d['denda'] > 0) ? '#ef4444' : '#22c55e' ?>">
                        Rp <?= number_format($d['denda'], 0, ',', '.') ?>
                    </b>
                </td>

                <td>
                    <span class="status">
                        <?= e($d['status']) ?>
                    </span>
                </td>

                <td>
                    <a class="btn btn-accept" href="terima.php?id=<?= $d['id'] ?>">Terima</a>
                    <a class="btn btn-reject" href="tolak.php?id=<?= $d['id'] ?>">Tolak</a>
                </td>
            </tr>

            <?php } ?>
        <?php else: ?>

            <tr>
                <td colspan="7" class="empty">
                    Tidak ada pengajuan pengembalian
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>
</html>