<?php
include '../../config/koneksi.php';

/* AMBIL DATA (URUT A-Z) */
$data = mysqli_query($conn,"
SELECT 
peminjaman.*,
users.username,
buku.judul,
buku.harga
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
ORDER BY users.username ASC
");

/* FORMAT RUPIAH */
function rupiah($angka){
    return "Rp " . number_format($angka,0,',','.');
}

/* HITUNG DENDA */
function denda($status,$tgl_kembali,$harga){
    $now = date('Y-m-d');
    $total = 0;

    // telat
    if($status == 'dipinjam' && $tgl_kembali){
        if($now > $tgl_kembali){
            $hari = (strtotime($now) - strtotime($tgl_kembali))/86400;
            $total = $hari * 10000;
        }
    }

    // rusak
    if($status == 'rusak'){
        $total = $harga * 0.5;
    }

    // hilang
    if($status == 'hilang'){
        $total = $harga;
    }

    return $total;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.container{
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

/* BUTTON */
.back{
    padding:8px 12px;
    background:#1e293b;
    border:1px solid #334155;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
}

.back:hover{
    background:#334155;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th,td{
    padding:12px;
    border-bottom:1px solid #334155;
    font-size:13px;
}

th{
    background:#0b1220;
    color:#94a3b8;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
}

.dipinjam{background:#facc15;color:black}
.kembali{background:#22c55e}
.menunggu{background:#38bdf8}
.rusak{background:#f97316}
.hilang{background:#ef4444}

/* DENDA */
.badge{
    color:#facc15;
    font-weight:bold;
}
</style>

</head>

<body>

<div class="container">

<!-- HEADER -->
<div class="header">
    <h2>📚 Data Peminjaman Buku</h2>
    <a href="../dashboard.php" class="back">← Kembali</a>
</div>

<table>

<tr>
<th>User</th>
<th>Buku</th>
<th>Status</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Denda / Ganti Rugi</th>
</tr>

<?php while($d = mysqli_fetch_assoc($data)) { 
$biaya = denda($d['status'],$d['tanggal_kembali'],$d['harga']);
?>

<tr>
<td><?= $d['username'] ?></td>
<td><?= $d['judul'] ?></td>

<td>
<span class="status <?= $d['status'] ?>">
<?= $d['status'] ?>
</span>
</td>

<td><?= $d['tanggal_pinjam'] ?></td>
<td><?= $d['tanggal_kembali'] ?? '-' ?></td>

<td>
<?php if($biaya > 0){ ?>
    <span class="badge"><?= rupiah($biaya) ?></span>
<?php } else { echo "-"; } ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>