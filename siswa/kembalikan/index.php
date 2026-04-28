<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../../config/koneksi.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

/* =========================
   GET ID
========================= */
$id = $_GET['id'] ?? 0;

/* =========================
   AMBIL DATA PEMINJAMAN
========================= */
$query = mysqli_query($conn, "
    SELECT peminjaman.*,
           buku.judul,
           buku.cover,
           buku.penulis,
           buku.penerbit,
           buku.tahun
    FROM peminjaman
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.id='$id'
    LIMIT 1
");

$d = mysqli_fetch_assoc($query);

/* =========================
   VALIDASI DATA
========================= */
if (!$d) {
    echo "<script>
        alert('Data tidak ditemukan');
        window.location='../dashboard.php';
    </script>";
    exit;
}

/* =========================
   DEFAULT VALUE
========================= */
$selisih = 0;
$denda   = 0;

/* =========================
   PROSES PENGAJUAN
========================= */
if (isset($_POST['kirim'])) {

    $tgl_pinjam  = $d['tanggal_pinjam'];
    $tgl_kembali = $_POST['tanggal_kembali'];

    $pinjam  = new DateTime($tgl_pinjam);
    $kembali = new DateTime($tgl_kembali);

    $selisih = $pinjam->diff($kembali)->days;

    $batas = 7;
    $denda = 0;

    if ($selisih > $batas) {
        $denda = ($selisih - $batas) * 1000;
    }

    $update = mysqli_query($conn, "
        UPDATE peminjaman SET
            status='menunggu_kembali',
            tanggal_kembali_rencana='$tgl_kembali',
            denda='$denda',
            denda_status='menunggu'
        WHERE id='$id'
    ");

    if ($update) {
        echo "<script>
            alert('Pengajuan berhasil dikirim!');
            window.location='../dashboard.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengirim pengajuan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengajuan Pengembalian</title>

<style>
body{
    font-family:Arial;
    background:#0f172a;
    margin:0;
    color:#e2e8f0;
}

.container{
    width:900px;
    margin:40px auto;
}

/* =========================
   CARD
========================= */
.card{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    border:1px solid #334155;
}

h2,h3{
    margin-top:0;
    color:#f1f5f9;
}

/* =========================
   LAYOUT
========================= */
.row{
    display:flex;
    gap:20px;
}

.col{
    flex:1;
}

/* =========================
   IMAGE
========================= */
img{
    width:100%;
    border-radius:10px;
    border:1px solid #334155;
}

/* =========================
   FORM
========================= */
label{
    font-weight:bold;
}

input[type="date"]{
    width:100%;
    padding:10px;
    margin-top:5px;
    border-radius:8px;
    border:1px solid #334155;
    background:#0f172a;
    color:#fff;
}

/* =========================
   BUTTON
========================= */
button{
    background:#3b82f6;
    color:#fff;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
    margin-top:10px;
}

button:hover{
    background:#2563eb;
}

/* =========================
   RESULT
========================= */
.result{
    background:#0b1220;
    border-left:5px solid #3b82f6;
    padding:15px;
    border-radius:8px;
}

.red{
    color:#ef4444;
    font-weight:bold;
}

.green{
    color:#22c55e;
    font-weight:bold;
}
</style>

</head>

<body>

<div class="container">

    <!-- DETAIL BUKU -->
    <div class="card">
        <h2>📚 Detail Buku</h2>

        <div class="row">
            <div class="col">
                <img src="../../uploads/<?= $d['cover']; ?>" alt="cover">
            </div>

            <div class="col">
                <p><b>Judul:</b> <?= $d['judul']; ?></p>
                <p><b>Penulis:</b> <?= $d['penulis']; ?></p>
                <p><b>Penerbit:</b> <?= $d['penerbit']; ?></p>
                <p><b>Tahun:</b> <?= $d['tahun']; ?></p>
                <p><b>Tanggal Pinjam:</b> <?= $d['tanggal_pinjam']; ?></p>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <div class="card">
        <h3>📌 Ajukan Pengembalian</h3>

        <form method="POST">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" required>

            <button type="submit" name="kirim">Kirim Pengajuan</button>
        </form>
    </div>

    <!-- HASIL -->
    <?php if (isset($_POST['kirim'])) { ?>
    <div class="card result">
        <h3>📊 Hasil Perhitungan</h3>

        <p>Selisih hari: <b><?= $selisih ?> hari</b></p>

        <p>Denda:
            <span class="<?= $denda > 0 ? 'red' : 'green' ?>">
                Rp <?= number_format($denda,0,',','.') ?>
            </span>
        </p>

        <?php if ($denda > 0) { ?>
            <p>⚠ Anda terlambat mengembalikan buku</p>
        <?php } else { ?>
            <p>✅ Tidak ada denda</p>
        <?php } ?>
    </div>
    <?php } ?>

</div>

</body>
</html>