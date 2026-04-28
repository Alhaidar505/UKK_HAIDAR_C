<?php

session_start();
require_once '../config/koneksi.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];

$user_id = $user['id'] ?? 0;
$nis     = $user['nis'] ?? '-';
$rayon   = $user['rayon'] ?? 'Belum diisi';
$alamat  = $user['alamat'] ?? 'Belum diisi';

/* =========================
   FUNCTION DENDA
========================= */
function hitungDenda($pinjam, $kembali)
{
    $batas = 7;
    $tarif = 1000;

    $p = new DateTime($pinjam);
    $k = new DateTime($kembali);

    $selisih = $p->diff($k)->days;

    return ($selisih > $batas)
        ? ($selisih - $batas) * $tarif
        : 0;
}

/* =========================
   QUERY DATA
========================= */
$buku = mysqli_query($conn, "
    SELECT * FROM buku WHERE stok > 0
");

$riwayat = mysqli_query($conn, "
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
<title>Dashboard Siswa</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:#e2e8f0;
}

.container{
    max-width:1100px;
    margin:auto;
    padding:25px;
}

/* =========================
   TOPBAR
========================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.logout{
    background:#ef4444;
    color:#fff;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

/* =========================
   CARD
========================= */
.card{
    background:#1e293b;
    border:1px solid #334155;
    padding:16px;
    border-radius:12px;
    margin-bottom:15px;
}

/* =========================
   GRID BUKU
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

/* =========================
   BUTTON
========================= */
.btn{
    display:inline-block;
    margin-top:10px;
    padding:8px 12px;
    background:#38bdf8;
    color:#000;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
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
    background:#0f172a;
    color:#94a3b8;
    text-align:left;
}

/* =========================
   STATUS BADGE
========================= */
.status{
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}

.menunggu{background:#facc15;color:#000}
.disetujui{background:#22c55e}
.dipinjam{background:#38bdf8}
.dikembalikan{background:#64748b}
.ditolak{background:#ef4444}

/* =========================
   DENDA
========================= */
.denda{font-weight:bold}
.merah{color:#ef4444}
.hijau{color:#22c55e}

/* pembayaran */
.lunas{background:#22c55e;color:#fff}
.belum{background:#facc15;color:#000}
</style>

</head>

<body>

<div class="container">

    <!-- TOPBAR -->
    <div class="topbar">
        <h2>📚 Dashboard Siswa</h2>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- USER INFO -->
    <div class="card">
        <h3><?= htmlspecialchars($user['username']); ?></h3>
        <p>NIS: <?= $nis; ?></p>
        <p><?= $rayon; ?> | <?= $alamat; ?></p>
    </div>

    <!-- BUKU -->
    <h3>📖 Buku Tersedia</h3>

    <div class="grid">
        <?php while ($row = mysqli_fetch_assoc($buku)) { ?>
            <div class="card">
                <h3><?= $row['judul']; ?></h3>
                <p>Stok: <?= $row['stok']; ?></p>
                <a class="btn" href="pengajuan/index.php?id=<?= $row['id']; ?>">
                    Ajukan
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- RIWAYAT -->
    <h3>📄 Riwayat Peminjaman</h3>

    <table>
        <tr>
            <th>Judul</th>
            <th>Pinjam</th>
            <th>Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($riwayat)) { ?>

        <?php
            $kembali = $r['tanggal_kembali_rencana'] ?? null;
            $denda   = $kembali ? hitungDenda($r['tanggal_pinjam'], $kembali) : 0;
        ?>

        <tr>
            <td><?= $r['judul']; ?></td>
            <td><?= $r['tanggal_pinjam']; ?></td>

            <td>
                <?= $kembali ? $kembali : '<span style="color:#64748b;">-</span>' ?>
            </td>

            <td>
                <span class="status <?= $r['status']; ?>">
                    <?= $r['status']; ?>
                </span>
            </td>

            <td>
                <?php if ($denda > 0) { ?>
                    <span class="denda merah">
                        Rp <?= number_format($denda,0,',','.') ?>
                    </span>
                <?php } else { ?>
                    <span class="denda hijau">0</span>
                <?php } ?>
            </td>

            <td>
                <?php if ($r['denda_status'] === 'sudah bayar') { ?>
                    <span class="status lunas">Sudah Dibayar</span>
                <?php } else { ?>
                    <span class="status belum">Belum Bayar</span>
                <?php } ?>
            </td>

            <td>
                <?php if (in_array($r['status'], ['disetujui', 'dipinjam'])) { ?>
                    <a class="btn" href="kembalikan/index.php?id=<?= $r['id']; ?>">
                        Kembalikan
                    </a>

                <?php } elseif ($r['status'] === 'menunggu_kembali') { ?>
                    <span style="color:#f59e0b;">Menunggu</span>

                <?php } elseif ($r['status'] === 'dikembalikan') { ?>
                    <span style="color:#22c55e;">Selesai</span>
                <?php } ?>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>