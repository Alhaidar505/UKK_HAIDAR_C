<?php
include '../../config/koneksi.php';

/* =========================
   HELPER RUPIAH
========================= */
function rupiah($angka){
    return "Rp " . number_format((int)$angka, 0, ',', '.');
}

/* =========================
   HITUNG DENDA
   (PINJAM vs KEMBALI RENCANA)
   1000 / hari, batas 7 hari
========================= */
function hitung_denda($tgl_pinjam, $tgl_kembali){
    $batas = 7;
    $tarif = 1000;
    $total = 0;

    if(!empty($tgl_pinjam) && !empty($tgl_kembali)){
        $pinjam  = new DateTime($tgl_pinjam);
        $kembali = new DateTime($tgl_kembali);

        $selisih = $pinjam->diff($kembali)->days;

        if($selisih > $batas){
            $total = ($selisih - $batas) * $tarif;
        }
    }

    return $total;
}

/* =========================
   AMBIL DATA PEMINJAMAN
========================= */
$query = mysqli_query($conn, "
SELECT 
    peminjaman.*,
    users.username,
    buku.judul
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Peminjaman</title>

<style>
body{
    background:#0f172a;
    color:white;
    font-family:'Segoe UI',sans-serif;
}

.container{
    max-width:1200px;
    margin:auto;
    padding:25px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.back{
    padding:8px 12px;
    background:#1e293b;
    border:1px solid #334155;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
}

/* TABLE */
.table-wrapper{overflow-x:auto;}

table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th,td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid #334155;
}

th{
    background:#0b1220;
    color:#94a3b8;
    text-align:left;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.dipinjam{background:rgba(250,204,21,0.15);color:#facc15}
.kembali{background:rgba(34,197,94,0.15);color:#22c55e}
.menunggu{background:rgba(56,189,248,0.15);color:#38bdf8}

/* DENDA */
.badge{
    background:#ef4444;
    color:white;
    padding:4px 10px;
    border-radius:999px;
    font-weight:bold;
}

/* MOBILE */
@media(max-width:600px){
    table,thead,tbody,tr,td{
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
        padding:8px 0;
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    td:last-child{border:none;}

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

<div class="header">
    <h2>📚 Data Peminjaman</h2>
    <a href="../dashboard.php" class="back">← Kembali</a>
</div>

<div class="table-wrapper">

<table>

<tr>
    <th>User</th>
    <th>Buku</th>
    <th>Status</th>
    <th>Pinjam</th>
    <th>Kembali Rencana</th>
    <th>Denda</th>
</tr>

<?php while($d = mysqli_fetch_assoc($query)) { 

    $tgl_kembali = $d['tanggal_kembali_rencana'] ?? null;

    $denda = hitung_denda(
        $d['tanggal_pinjam'],
        $tgl_kembali
    );
?>

<tr>

<td data-label="User"><?= $d['username'] ?></td>
<td data-label="Buku"><?= $d['judul'] ?></td>

<td data-label="Status">
    <span class="status <?= $d['status'] ?>">
        <?= $d['status'] ?>
    </span>
</td>

<td data-label="Pinjam"><?= $d['tanggal_pinjam'] ?></td>

<td data-label="Kembali">
    <?= $tgl_kembali ? $tgl_kembali : '-' ?>
</td>

<td data-label="Denda">
    <?php if($denda > 0){ ?>
        <span class="badge">
            <?= rupiah($denda) ?>
        </span>
    <?php } else { ?>
        -
    <?php } ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>