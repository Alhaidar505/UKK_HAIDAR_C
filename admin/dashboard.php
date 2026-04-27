<?php 
session_start();
include '../config/koneksi.php';

/* =========================
   HITUNG DATA
========================= */
$jumlah_siswa = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM users"));
$jumlah_buku = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM buku"));
$jumlah_laporan = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM peminjaman WHERE status!='menunggu'"));
$jumlah_pinjam = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM peminjaman"));
$jumlah_kategori = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM kategori"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<style>
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
    background:#111827;
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
    transition:0.2s;
}

.logout-btn:hover{
    background:#dc2626;
    transform:scale(1.05);
}

/* CONTAINER */
.container{
    padding:25px;
    max-width:1200px;
    margin:auto;
}

/* WELCOME */
.welcome{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    padding:22px;
    border-radius:14px;
    margin-bottom:25px;
    color:#0f172a;
}

.welcome h3{
    font-size:20px;
    margin-bottom:5px;
}

/* GRID */
.menu{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
    gap:18px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    padding:22px;
    border-radius:16px;
    text-align:center;
    transition:0.25s;
    backdrop-filter: blur(10px);
    cursor:pointer;
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.12);
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

.icon{
    font-size:28px;
    margin-bottom:10px;
}

.count{
    font-size:32px;
    font-weight:bold;
    color:#38bdf8;
    margin:6px 0;
}

.card a{
    text-decoration:none;
    color:white;
    font-weight:600;
    font-size:14px;
    display:block;
    margin-top:6px;
}

/* RESPONSIVE */
@media(max-width:600px){
    .navbar h2{
        font-size:16px;
    }

    .container{
        padding:15px;
    }

    .card{
        padding:18px;
    }

    .count{
        font-size:26px;
    }
}
</style>
</head>

<body>

<div class="navbar">
    <h2>📊 Dashboard Admin</h2>
    <a href="../auth/logout.php" class="logout-btn">Logout</a>
</div>

<div class="container">

    <div class="welcome">
        <h3>Selamat Datang, Admin 👋</h3>
        <p>Kelola seluruh data perpustakaan dengan cepat & efisien</p>
    </div>

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
            <div class="title">Kategori</div>
            <div class="count"><?= $jumlah_kategori ?></div>
            <a href="kategori/index.php">Kelola Kategori</a>
        </div>

        <div class="card">
            <div class="icon">📜</div>
            <div>Logs</div>
            <a href="logs/index.php">Riwayat Sistem</a>
        </div>
    </div>

</div>

</body>
</html>