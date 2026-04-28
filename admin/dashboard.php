<?php 
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

/* FUNCTION HITUNG DATA */
function countData($conn, $query){
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

/*  AMBIL DATA  */
$jumlah_siswa    = countData($conn, "SELECT id FROM users");
$jumlah_buku     = countData($conn, "SELECT id FROM buku");
$jumlah_laporan  = countData($conn, "SELECT id FROM peminjaman WHERE status!='menunggu'");
$jumlah_pinjam   = countData($conn, "SELECT id FROM peminjaman");
$jumlah_kategori = countData($conn, "SELECT id FROM kategori");
$jumlah_logs     = countData($conn, "SELECT id FROM logs");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>

<style>
/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:#0f172a;
    color:white;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 25px;
    background:rgba(17,24,39,0.9);
    border-bottom:1px solid rgba(255,255,255,0.08);
    position:sticky;
    top:0;
}

.navbar h2{
    font-size:18px;
}

.logout-btn{
    padding:8px 14px;
    background:#ef4444;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
    transition:0.3s;
}

.logout-btn:hover{
    background:#dc2626;
}

/* CONTAINER */
.container{
    padding:25px;
    max-width:1200px;
    margin:auto;
}

/* WELCOME */
.welcome{
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    padding:22px;
    border-radius:16px;
    margin-bottom:25px;
    color:#0f172a;
}

/* GRID */
.menu{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(180px,1fr));
    gap:16px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    padding:20px;
    border-radius:16px;
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.12);
}

/* ICON */
.icon{
    font-size:26px;
    margin-bottom:8px;
}

/* COUNT */
.count{
    font-size:28px;
    font-weight:bold;
    color:#38bdf8;
}

/* LINK */
.card a{
    display:block;
    margin-top:6px;
    font-size:13px;
    color:white;
    text-decoration:none;
    opacity:0.8;
}

.card a:hover{
    opacity:1;
}

/* RESPONSIVE */
@media(max-width:600px){
    .container{
        padding:15px;
    }

    .navbar h2{
        font-size:16px;
    }

    .count{
        font-size:24px;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Dashboard Admin</h2>
    <a href="../auth/logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

    <!-- WELCOME -->
    <div class="welcome">
        <h3>Selamat Datang, Admin 👋</h3>
        <p>Perpus Digital | Wikrama 1 Garut</p>
    </div>

    <!-- MENU -->
    <div class="menu">

        <div class="card">
            <div class="icon">👨‍🎓</div>
            <div>Siswa</div>
            <div class="count"><?= $jumlah_siswa ?></div>
            <a href="siswa/user.php">Kelola Data</a>
        </div>

        <div class="card">
            <div class="icon">📚</div>
            <div>Buku</div>
            <div class="count"><?= $jumlah_buku ?></div>
            <a href="buku/index.php">Kelola Buku</a>
        </div>

        <div class="card">
            <div class="icon">📄</div>
            <div>Laporan</div>
            <div class="count"><?= $jumlah_laporan ?></div>
            <a href="laporan/index.php">Lihat Laporan</a>
        </div>

        <div class="card">
            <div class="icon">📥</div>
            <div>Peminjaman</div>
            <div class="count"><?= $jumlah_pinjam ?></div>
            <a href="peminjaman/index.php">Data Peminjaman</a>
        </div>

        <div class="card">
            <div class="icon">🏷️</div>
            <div>Kategori</div>
            <div class="count"><?= $jumlah_kategori ?></div>
            <a href="kategori/index.php">Kelola Kategori</a>
        </div>

        <div class="card">
            <div class="icon">📜</div>
            <div>Logs</div>
            <div class="count"><?= $jumlah_logs ?></div>
            <a href="logs/index.php">Riwayat Sistem</a>
        </div>

    </div>

</div>

</body>
</html>