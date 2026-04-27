<?php
include '../../config/koneksi.php';

// SEARCH
$cari = $_GET['cari'] ?? '';

// QUERY: hanya siswa + urut berdasarkan nama
$data = mysqli_query($conn, "
SELECT * FROM users 
WHERE role = 'peminjam'
AND (
    username LIKE '%$cari%' 
    OR nama LIKE '%$cari%' 
    OR nis LIKE '%$cari%'
)
ORDER BY nama ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Siswa</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI';}

body{
    background:#0f172a;
    color:white;
}

.container{
    padding:30px;
}

h2{
    margin-bottom:10px;
}

/* TOP BAR */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.btn{
    padding:10px 15px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
}

.btn-back{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    color:white;
}

.btn-add{
    background:#22c55e;
    color:white;
}

/* SEARCH */
input{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:10px;
    border:none;
    background: rgba(255,255,255,0.1);
    color:white;
}

/* TABLE */
table{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th, td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.1);
    font-size:13px;
}

th{
    color:#94a3b8;
    text-align:left;
}

/* ACTION */
.action a{
    margin-right:8px;
}

/* HOVER */
tr:hover{
    background:#0f172a;
}
</style>
</head>

<body>

<div class="container">

<div class="top-bar">
    <a href="../dashboard.php" class="btn btn-back">← Kembali</a>
    <a href="tambah_user.php" class="btn btn-add">+ Tambah Siswa</a>
</div>

<h2>📚 Data Siswa</h2>

<!-- SEARCH -->
<form method="GET">
    <input type="text" name="cari" placeholder="Cari nama / NIS / username..." value="<?= $cari ?>">
</form>

<!-- TABLE -->
<table>

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Username</th>
    <th>NIS</th>
    <th>Rayon</th>
    <th>Alamat</th>
    <th>Aksi</th>
</tr>

<?php 
$no = 1;
if(mysqli_num_rows($data) > 0){ 
while($u = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $u['nama'] ?></td>
    <td><?= $u['username'] ?></td>
    <td><?= $u['nis'] ?></td>
    <td><?= $u['rayon'] ?></td>
    <td><?= $u['alamat'] ?></td>
    <td class="action">
        <a href="edit_user.php?id=<?= $u['id'] ?>" style="color:yellow;">✏ Edit</a>
        <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin hapus?')" style="color:red;">🗑 Hapus</a>
    </td>
</tr>
<?php } } else { ?>
<tr>
    <td colspan="7" style="text-align:center;color:#94a3b8;">
        Tidak ada data siswa
    </td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>