<?php

session_start();
require_once '../../config/koneksi.php';
require_once '../../config/logs.php';

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user'])) {
    header("Location: ../../login.php");
    exit;
}

/* =========================
   USER DATA
========================= */
$user   = $_SESSION['user'];
$user_id = $user['id'];
$nama    = $user['nama'];
$role    = $user['role'];

/* =========================
   AMBIL BUKU
========================= */
$buku_id = $_GET['id'] ?? 0;

$query_buku = mysqli_query($conn, "
    SELECT * FROM buku WHERE id='$buku_id'
");

$buku = mysqli_fetch_assoc($query_buku);

/* =========================
   VALIDASI BUKU
========================= */
if (!$buku) {
    echo "<script>
        alert('Buku tidak ditemukan');
        window.location='../dashboard.php';
    </script>";
    exit;
}

/* =========================
   CEK STOK
========================= */
if ($buku['stok'] <= 0) {
    echo "<script>
        alert('Stok buku habis!');
        window.location='../dashboard.php';
    </script>";
    exit;
}

/* =========================
   CEK PEMINJAMAN AKTIF
   (HANYA 1 BUKU)
========================= */
$cek_aktif = mysqli_query($conn, "
    SELECT id FROM peminjaman 
    WHERE user_id='$user_id'
    AND status IN ('menunggu','disetujui','dipinjam','menunggu_kembali')
");

if (mysqli_num_rows($cek_aktif) > 0) {
    echo "<script>
        alert('Kamu hanya boleh meminjam 1 buku terlebih dahulu!');
        window.location='../dashboard.php';
    </script>";
    exit;
}

/* =========================
   PROSES PINJAM
========================= */
if (isset($_POST['pinjam'])) {

    mysqli_query($conn, "
        INSERT INTO peminjaman 
        (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status)
        VALUES
        ('$user_id','$buku_id',NOW(),NULL,'menunggu')
    ");

    mysqli_query($conn, "
        UPDATE buku 
        SET stok = stok - 1 
        WHERE id='$buku_id'
    ");

    simpan_log(
        $conn,
        $user_id,
        $nama,
        $role,
        "Mengajukan peminjaman buku: " . $buku['judul']
    );

    echo "<script>
        alert('Pengajuan berhasil dikirim!');
        window.location='../dashboard.php';
    </script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Buku</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:#fff;
}

.container{
    padding:20px;
    max-width:900px;
    margin:auto;
}

/* =========================
   TOPBAR
========================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.back{
    padding:8px 12px;
    background:#1e293b;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    border:1px solid #334155;
}

/* =========================
   CARD
========================= */
.card{
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#0b1220;
    color:#94a3b8;
    text-align:left;
    padding:12px;
    font-size:13px;
}

td{
    padding:12px;
    border-bottom:1px solid #334155;
    font-size:13px;
}

/* =========================
   COVER
========================= */
.cover{
    width:80px;
    height:110px;
    object-fit:cover;
    border-radius:8px;
}

/* =========================
   BUTTON
========================= */
button{
    padding:10px 14px;
    background:#38bdf8;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    opacity:0.85;
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:600px){

    table, thead, tbody, tr, td{
        display:block;
        width:100%;
    }

    thead{display:none;}

    tr{
        background:#1e293b;
        margin-bottom:15px;
        border-radius:12px;
        padding:12px;
    }

    td{
        display:flex;
        justify-content:space-between;
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    td:last-child{
        border-bottom:none;
    }

    td::before{
        content:attr(data-label);
        color:#94a3b8;
        font-weight:600;
    }
}
</style>

</head>

<body>

<div class="container">

    <div class="topbar">
        <h3>📚 Pengajuan Buku</h3>
        <a href="../dashboard.php" class="back">← Kembali</a>
    </div>

    <div class="card">

        <form method="POST">

            <table>

                <tr>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>

                <tr>

                    <td data-label="Cover">
                        <?php if (!empty($buku['cover'])) { ?>
                            <img class="cover" src="../../uploads/<?= $buku['cover']; ?>" alt="cover">
                        <?php } else { ?>
                            No Cover
                        <?php } ?>
                    </td>

                    <td data-label="Judul"><?= $buku['judul']; ?></td>
                    <td data-label="Penulis"><?= $buku['penulis']; ?></td>
                    <td data-label="Penerbit"><?= $buku['penerbit']; ?></td>
                    <td data-label="Tahun"><?= $buku['tahun']; ?></td>
                    <td data-label="Stok"><?= $buku['stok']; ?></td>

                    <td data-label="Aksi">
                        <button type="submit" name="pinjam">Ajukan</button>
                    </td>

                </tr>

            </table>

        </form>

    </div>

</div>

</body>
</html>