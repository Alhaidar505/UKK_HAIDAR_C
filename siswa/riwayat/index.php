<?php

session_start();
require_once '../../config/koneksi.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

/* =========================
   QUERY DATA
========================= */
$data = mysqli_query($conn, "
    SELECT peminjaman.*, buku.judul
    FROM peminjaman
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.user_id = '$user_id'
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
    color:#fff;
    margin:0;
}

.container{
    padding:30px;
}

/* =========================
   HEADER
========================= */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.btn-back{
    padding:8px 12px;
    background:#1e293b;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    border:1px solid #334155;
}

/* =========================
   TABLE BOX
========================= */
.table-box{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    border-bottom:1px solid #334155;
    font-size:13px;
}

th{
    color:#94a3b8;
    text-align:left;
}

/* =========================
   STATUS BADGE
========================= */
.status{
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
}

.menunggu{background:#facc15;color:#000}
.disetujui{background:#22c55e;color:#fff}
.ditolak{background:#ef4444;color:#fff}
.dipinjam{background:#38bdf8;color:#fff}
.menunggu_kembali{background:#f97316;color:#fff}

/* =========================
   STRUK BUTTON
========================= */
.struk{
    padding:5px 10px;
    background:#38bdf8;
    color:#000;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
}

/* =========================
   DENDA
========================= */
.denda{
    font-weight:bold;
}

.merah{color:#ef4444}
.hijau{color:#22c55e}
</style>

</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>📚 Riwayat Peminjaman</h2>
        <a href="../dashboard.php" class="btn-back">← Kembali</a>
    </div>

    <!-- TABLE -->
    <div class="table-box">

        <table>
            <tr>
                <th>Judul</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Aksi</th>
            </tr>

            <?php while ($r = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $r['judul']; ?></td>
                <td><?= $r['tanggal_pinjam']; ?></td>

                <td>
                    <span class="status <?= $r['status']; ?>">
                        <?= $r['status']; ?>
                    </span>
                </td>

                <td>
                    <?php if (!empty($r['denda']) && $r['denda'] > 0) { ?>
                        <span class="denda merah">
                            Rp <?= number_format($r['denda'], 0, ',', '.') ?>
                        </span>
                    <?php } else { ?>
                        <span class="denda hijau">
                            Tidak ada
                        </span>
                    <?php } ?>
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