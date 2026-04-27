<?php
include '../config/koneksi.php';

$data = mysqli_query($conn,"
SELECT peminjaman.*, users.username, buku.judul, buku.harga
FROM peminjaman
JOIN users ON peminjaman.user_id = users.id
JOIN buku ON peminjaman.buku_id = buku.id
WHERE peminjaman.status!='menunggu'
ORDER BY peminjaman.id DESC
");

function rupiah($angka){
    return "Rp " . number_format($angka,0,',','.');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Riwayat & Struk Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.container{padding:30px;}

h2{margin-bottom:15px;}

.back{
    display:inline-block;
    margin-bottom:15px;
    color:#38bdf8;
    text-decoration:none;
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
    font-size:13px;
    border-bottom:1px solid #334155;
}

th{
    background:#0b1220;
    color:#94a3b8;
}

tr:hover{
    background:#111c33;
    cursor:pointer;
}

/* STATUS */
.status{
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    display:inline-block;
    text-transform:capitalize;
}

.dipinjam{background:#38bdf8}
.kembali{background:#22c55e}
.rusak{background:#f97316}
.hilang{background:#ef4444}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
}

.modal-content{
    width:380px;
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    text-align:center;
    border:1px solid #334155;
}

.close{
    float:right;
    cursor:pointer;
    color:#ef4444;
    font-weight:bold;
}

.info{
    text-align:left;
    font-size:13px;
    margin:6px 0;
    color:#cbd5e1;
}

/* QR */
.qr img{
    margin-top:10px;
    width:140px;
    background:white;
    padding:6px;
    border-radius:10px;
}
</style>

</head>

<body>

<div class="container">

<a href="dashboard.php" class="back">← Kembali</a>

<h2>📄 Riwayat Peminjaman</h2>

<table>

<tr>
    <th>No</th>
    <th>User</th>
    <th>Buku</th>
    <th>Tgl Pengajuan</th>
    <th>Tgl Pengembalian</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php 
$no = 1;
while($d = mysqli_fetch_assoc($data)) { 
?>

<tr onclick="openModal(
    '<?= $d['username'] ?>',
    '<?= $d['judul'] ?>',
    '<?= $d['status'] ?>',
    '<?= $d['tanggal_pinjam'] ?>',
    '<?= $d['tanggal_kembali'] ?? '-' ?>',
    '<?= rupiah($d['harga']) ?>',
    '<?= $d['id'] ?>'
)">

    <td><?= $no++ ?></td>
    <td><?= $d['username'] ?></td>
    <td><?= $d['judul'] ?></td>

    <!-- TGL PENGAJUAN -->
    <td><?= $d['tanggal_pinjam'] ?? '-' ?></td>

    <!-- TGL PENGEMBALIAN -->
    <td><?= $d['tanggal_kembali'] ?? '-' ?></td>

    <td>
        <span class="status <?= $d['status'] ?>">
            <?= $d['status'] ?>
        </span>
    </td>

    <td>👁 Lihat Struk</td>

</tr>

<?php } ?>

</table>

</div>

<!-- MODAL -->
<div class="modal" id="modal">
    <div class="modal-content">

        <span class="close" onclick="closeModal()">✖</span>

        <h3>📄 Detail Struk</h3>

        <p class="info"><b>User:</b> <span id="user"></span></p>
        <p class="info"><b>Buku:</b> <span id="buku"></span></p>
        <p class="info"><b>Status:</b> <span id="status"></span></p>
        <p class="info"><b>Tgl Pengajuan:</b> <span id="pinjam"></span></p>
        <p class="info"><b>Tgl Pengembalian:</b> <span id="kembali"></span></p>
        <p class="info"><b>Harga:</b> <span id="harga"></span></p>

        <div class="qr">
            <img id="qr">
        </div>

    </div>
</div>

<script>
function openModal(user,buku,status,pinjam,kembali,harga,id){

    document.getElementById('user').innerText = user;
    document.getElementById('buku').innerText = buku;
    document.getElementById('status').innerText = status;
    document.getElementById('pinjam').innerText = pinjam;
    document.getElementById('kembali').innerText = kembali;
    document.getElementById('harga').innerText = harga;

    document.getElementById('qr').src =
    "https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=ID:" + id;

    document.getElementById('modal').style.display = 'flex';
}

function closeModal(){
    document.getElementById('modal').style.display = 'none';
}
</script>

</body>
</html>