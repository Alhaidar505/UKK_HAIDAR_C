<?php
include '../../config/koneksi.php';

/* 
   AMBIL DATA LAPORAN
 */
$query = mysqli_query($conn, "
    SELECT 
        p.id AS id_pinjam,
        u.nama,
        b.judul,
        b.cover,
        k.nama_kategori,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status,
        p.catatan,
        p.created_at
    FROM peminjaman p
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN buku b ON p.buku_id = b.id
    LEFT JOIN kategori k ON b.kategori_id = k.id
    ORDER BY p.created_at DESC
");

/* 
   KONVERSI DATA
 */
$laporan = [];
while($row = mysqli_fetch_assoc($query)){
    $laporan[] = $row;
}

/* 
   HELPERS
 */
function escape($text){
    return htmlspecialchars($text ?? '');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Pengajuan</title>

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

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
    gap:10px;
}

.header h2{
    font-size:20px;
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

.card{
    background:#1e293b;
    border-radius:14px;
    overflow:hidden;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1100px;
}

th,td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid #334155;
    text-align:left;
}

th{
    background:#0b1220;
    color:#94a3b8;
}

tr:hover{
    background:#111c33;
}

/* COVER */
.cover-img{
    width:45px;
    height:65px;
    object-fit:cover;
    border-radius:6px;
    background:#334155;
}

.no-cover{
    width:45px;
    height:65px;
    background:#334155;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:10px;
    color:#94a3b8;
}

/* STATUS */
.status{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
    text-transform:capitalize;
}

.status::before{
    content:"●";
    font-size:10px;
}

.menunggu{ background:rgba(250,204,21,0.15); color:#facc15; }
.disetujui{ background:rgba(34,197,94,0.15); color:#22c55e; }
.ditolak{ background:rgba(239,68,68,0.15); color:#ef4444; }

/* BUTTON */
.btn{
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
    text-decoration:none;
    display:inline-block;
}

.accept{background:#22c55e;color:white}
.reject{background:#ef4444;color:white}

.empty{
    text-align:center;
    padding:20px;
    color:#94a3b8;
}

/* RESPONSIVE */
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

    td:last-child{border-bottom:none;}

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
    <h2>Laporan Pengajuan Peminjaman Buku</h2>
    <a href="../dashboard.php" class="back">← Kembali</a>
</div>

<div class="card">
<div class="table-wrapper">

<table>

<tr>
    <th>Cover</th>
    <th>ID</th>
    <th>Nama</th>
    <th>Buku</th>
    <th>Kategori</th>
    <th>Pengajuan</th>
    <th>Pinjam</th>
    <th>Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php if(count($laporan) > 0): ?>
<?php foreach($laporan as $d): ?>

<tr>

    <td data-label="Cover">
        <?php if(!empty($d['cover'])): ?>
            <img class="cover-img" src="../../uploads/<?= escape($d['cover']) ?>">
        <?php else: ?>
            <div class="no-cover">No Cover</div>
        <?php endif; ?>
    </td>

    <td data-label="ID">#<?= escape($d['id_pinjam']) ?></td>
    <td data-label="Nama"><?= escape($d['nama']) ?></td>
    <td data-label="Buku"><?= escape($d['judul']) ?></td>
    <td data-label="Kategori"><?= escape($d['nama_kategori']) ?></td>

    <!-- PENGAJUAN -->
    <td data-label="Pengajuan">
        <?= date('d-m-Y H:i', strtotime($d['created_at'])) ?>
    </td>

    <td data-label="Pinjam"><?= escape($d['tanggal_pinjam']) ?></td>
    <td data-label="Kembali"><?= $d['tanggal_kembali'] ?? '-' ?></td>

    <td data-label="Status">
        <span class="status <?= escape($d['status']) ?>">
            <?= escape($d['status']) ?>
        </span>
    </td>

    <td data-label="Aksi">
        <?php if($d['status'] === 'menunggu'): ?>
            <a href="terima_laporan.php?id=<?= $d['id_pinjam'] ?>" class="btn accept">Terima</a>
            <a href="tolak_laporan.php?id=<?= $d['id_pinjam'] ?>" class="btn reject">Tolak</a>
        <?php else: ?>
            <span style="color:#94a3b8;">Selesai</span>
        <?php endif; ?>
    </td>

</tr>

<?php endforeach; ?>
<?php else: ?>

<tr>
    <td colspan="10" class="empty">Tidak ada data pengajuan</td>
</tr>

<?php endif; ?>

</table>

</div>
</div>

</div>

</body>
</html>