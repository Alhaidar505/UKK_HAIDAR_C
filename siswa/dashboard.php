<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$nis = $user['nis'];
$rayon = $user['rayon'] ?? 'Belum diisi';
$alamat = $user['alamat'] ?? 'Belum diisi';

/* BUKU */
$buku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");

/* RIWAYAT */
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

.container{
    padding:25px;
    max-width:1200px;
    margin:auto;
}

/* PROFILE */
.profile{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    background:linear-gradient(135deg,#1e293b,#0f172a);
    padding:22px;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.08);
    margin-bottom:25px;
}

.profile-left{
    display:flex;
    gap:15px;
    align-items:center;
}

.avatar{
    width:60px;
    height:60px;
    border-radius:50%;
    background:#38bdf8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    color:black;
    font-size:20px;
}

.badge{
    display:inline-block;
    padding:4px 10px;
    background:#22c55e;
    color:black;
    border-radius:8px;
    font-size:12px;
    margin-top:5px;
}

.alamat{
    font-size:12px;
    color:#94a3b8;
}

.profile-right{
    text-align:center;
}

.qr img{
    width:110px;
    background:white;
    padding:6px;
    border-radius:12px;
}

.logout{
    display:inline-block;
    margin-top:10px;
    padding:8px 14px;
    background:#ef4444;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    transition:0.2s;
}

.logout:hover{
    background:#dc2626;
}

/* SECTION TITLE */
h2{
    margin:20px 0 15px;
    font-size:18px;
    color:#38bdf8;
}

/* GRID BUKU */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}

.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    padding:18px;
    border-radius:14px;
    transition:0.25s;
}

.card:hover{
    transform:translateY(-5px);
    background:rgba(255,255,255,0.12);
}

.btn{
    display:inline-block;
    margin-top:10px;
    padding:8px 12px;
    background:#38bdf8;
    color:black;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
    transition:0.2s;
}

.btn:hover{
    transform:scale(1.05);
}

/* TABLE */
.table{
    width:100%;
    margin-top:10px;
    border-collapse:collapse;
    background:rgba(255,255,255,0.06);
    border-radius:12px;
    overflow:hidden;
}

.table th,
.table td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

.table th{
    background:#111827;
    color:#94a3b8;
    text-align:left;
}

/* STATUS */
.status{
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
    display:inline-block;
}

.menunggu{background:#facc15;color:black}
.disetujui{background:#22c55e}
.dipinjam{background:#38bdf8}
.dikembalikan{background:#64748b}
.ditolak{background:#ef4444}

/* RESPONSIVE */
@media(max-width:600px){
    .profile{
        flex-direction:column;
        text-align:center;
    }

    .profile-left{
        flex-direction:column;
    }

    .table{
        display:block;
        overflow-x:auto;
        white-space:nowrap;
    }
}
</style>

</head>

<body>

<div class="container">

<!-- PROFILE -->
<div class="profile">

    <div class="profile-left">
        <div class="avatar"><?= strtoupper(substr($user['username'],0,1)); ?></div>
        <div>
            <h3><?= $user['username']; ?></h3>
            <p>NIS: <?= $nis; ?></p>
            <span class="badge"><?= $rayon; ?></span>
            <p class="alamat"><?= $alamat; ?></p>
        </div>
    </div>

    <div class="profile-right">
        <div class="qr">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=<?= $nis; ?>">
        </div>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

</div>

<!-- BUKU -->
<h2>📚 Buku Tersedia</h2>

<div class="grid">
<?php while($row = mysqli_fetch_assoc($buku)) { ?>
    <div class="card">
        <h3><?= $row['judul']; ?></h3>
        <p>Stok: <?= $row['stok']; ?></p>
        <a class="btn" href="pengajuan/index.php?id=<?= $row['id']; ?>">Ajukan</a>
    </div>
<?php } ?>
</div>

<!-- RIWAYAT -->
<h2>📄 Riwayat Pengajuan dan Peminjaman</h2>

<table class="table">
<tr>
    <th>Judul</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($r = mysqli_fetch_assoc($riwayat)) { ?>
<tr>
    <td><?= $r['judul']; ?></td>
    <td><?= $r['tanggal_pinjam']; ?></td>

    <td>
        <span class="status <?= $r['status']; ?>">
            <?= $r['status']; ?>
        </span>
    </td>

    <td>

    <?php if($r['status'] == 'disetujui'){ ?>
        <a class="btn" href="riwayat/struk.php?id=<?= $r['id']; ?>">Struk</a>

    <?php } elseif($r['status'] == 'dipinjam'){ ?>
        <a class="btn" href="kembalikan/index.php?id=<?= $r['id']; ?>"
           onclick="return confirm('Kembalikan buku?')">
           Kembalikan
        </a>

    <?php } elseif($r['status'] == 'dikembalikan'){ ?>
        <span style="color:#22c55e;">Selesai</span>

    <?php } elseif($r['status'] == 'menunggu'){ ?>
        <span style="color:#facc15;">Menunggu</span>

    <?php } elseif($r['status'] == 'ditolak'){ ?>
        <span style="color:#ef4444;">Ditolak</span>
    <?php } ?>

    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>