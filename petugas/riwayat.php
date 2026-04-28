<?php

session_start();
require_once '../config/koneksi.php';

/* =========================
   QUERY DATA
========================= */
$query = mysqli_query($conn, "
    SELECT peminjaman.*, users.username, buku.judul, buku.harga, peminjaman.denda_status
    FROM peminjaman
    JOIN users ON peminjaman.user_id = users.id
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.status != 'menunggu'
    ORDER BY peminjaman.id DESC
");

/* =========================
   FORMAT RUPIAH
========================= */
function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

/* =========================
   HITUNG DENDA
========================= */
function hitungDenda($pinjam, $rencana)
{
    if (!$pinjam || !$rencana) return 0;

    $batas = 7;
    $tarif = 1000;

    $p = new DateTime($pinjam);
    $r = new DateTime($rencana);

    $selisih = $p->diff($r)->days;

    return ($selisih > $batas)
        ? ($selisih - $batas) * $tarif
        : 0;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:#fff;
}

.container{
    padding:30px;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
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

/* =========================
   STATUS
========================= */
.status{
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    background:#334155;
}

/* =========================
   DENDA
========================= */
.denda{color:#ef4444;font-weight:bold;}
.nodenda{color:#22c55e;font-weight:bold;}

/* =========================
   PAYMENT STATUS
========================= */
.lunas{color:#22c55e;font-weight:bold;}
.belum{color:#facc15;font-weight:bold;}

/* =========================
   BUTTON
========================= */
.btn{
    padding:6px 10px;
    background:#38bdf8;
    color:#000;
    border-radius:6px;
    text-decoration:none;
    font-size:12px;
    display:inline-block;
}

.back{
    display:inline-block;
    margin-bottom:10px;
    color:#94a3b8;
    text-decoration:none;
}
</style>

</head>

<body>

<div class="container">

    <h2>📄 Riwayat Peminjaman</h2>
    <a href="dashboard.php" class="back">← Kembali</a>

    <table>

        <tr>
            <th>No</th>
            <th>User</th>
            <th>Buku</th>
            <th>Pinjam</th>
            <th>Rencana</th>
            <th>Denda</th>
            <th>Status</th>
            <th>Pembayaran</th>
        </tr>

        <?php $no = 1; while ($d = mysqli_fetch_assoc($query)) { ?>

        <?php $denda = hitungDenda($d['tanggal_pinjam'], $d['tanggal_kembali_rencana']); ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['username'] ?></td>
            <td><?= $d['judul'] ?></td>
            <td><?= $d['tanggal_pinjam'] ?></td>
            <td><?= $d['tanggal_kembali_rencana'] ?? '-' ?></td>

            <td>
                <?php if ($denda > 0) { ?>
                    <span class="denda"><?= rupiah($denda) ?></span>
                <?php } else { ?>
                    <span class="nodenda">0</span>
                <?php } ?>
            </td>

            <td>
                <span class="status"><?= $d['status'] ?></span>
            </td>

            <td>
                <?php if ($d['denda_status'] === 'sudah bayar') { ?>
                    <span class="lunas">Sudah Bayar</span>
                <?php } else { ?>
                    <span class="belum">Belum Bayar</span>
                <?php } ?>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>