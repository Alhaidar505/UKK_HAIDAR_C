<?php
include '../../config/koneksi.php';

/* INPUT & VALIDASI */
$cari = $_GET['cari'] ?? '';
$cari_safe = mysqli_real_escape_string($conn, $cari);

/* QUERY DATA */
$query = "
SELECT * FROM users 
WHERE role = 'peminjam'
AND (
    username LIKE '%$cari_safe%' 
    OR nama LIKE '%$cari_safe%' 
    OR nis LIKE '%$cari_safe%'
)
ORDER BY nama ASC
";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Siswa</title>

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

/* CONTAINER */
.container{
    padding:25px;
    max-width:1200px;
    margin:auto;
}

/* TOP BAR */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:15px;
}

/* BUTTON */
.btn{
    padding:10px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    transition:0.3s;
}

.btn-back{
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    color:white;
}

.btn-add{
    background:#22c55e;
    color:white;
}

.btn:hover{
    transform:scale(1.05);
}

/* SEARCH */
.search-box input{
    width:100%;
    padding:12px;
    margin:10px 0 20px;
    border-radius:10px;
    border:none;
    background:rgba(255,255,255,0.1);
    color:white;
    outline:none;
}

/* TABLE */
.table-wrapper{
    width:100%;
    overflow-x:auto;
    border-radius:12px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#1e293b;
    min-width:700px;
}

th, td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    font-size:13px;
}

th{
    background:#0f172a;
    color:#94a3b8;
    text-align:left;
}

tr:hover{
    background:#0f172a;
}

/* ACTION */
.action a{
    margin-right:10px;
    text-decoration:none;
}

/* EMPTY */
.empty{
    text-align:center;
    color:#94a3b8;
    padding:20px;
}

/* RESPONSIVE */
@media (max-width:600px){

    thead{
        display:none;
    }

    table, tbody, tr, td{
        display:block;
        width:100%;
    }

    tr{
        margin-bottom:15px;
        background:#1e293b;
        border-radius:12px;
        padding:12px;
    }

    td{
        display:flex;
        justify-content:space-between;
        padding:8px 0;
        border:none;
        border-bottom:1px solid rgba(255,255,255,0.08);
    }

    td:last-child{
        border-bottom:none;
    }

    td::before{
        content:attr(data-label);
        font-weight:600;
        color:#94a3b8;
    }

    .action{
        justify-content:flex-end;
        gap:10px;
    }
}
</style>
</head>

<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="top-bar">
        <a href="../dashboard.php" class="btn btn-back">← Kembali</a>
        <a href="tambah_user.php" class="btn btn-add">+ Tambah Siswa</a>
    </div>

    <h2>📚 Data Siswa</h2>

    <!-- SEARCH -->
    <form method="GET" class="search-box">
        <input 
            type="text" 
            name="cari" 
            placeholder="Cari nama / NIS / username..." 
            value="<?= htmlspecialchars($cari) ?>"
        >
    </form>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>NIS</th>
                    <th>Rayon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php 
            $no = 1;
            if(mysqli_num_rows($data) > 0): 
                while($u = mysqli_fetch_assoc($data)): 
            ?>
                <tr>
                    <td data-label="No"><?= $no++ ?></td>
                    <td data-label="Nama"><?= htmlspecialchars($u['nama']) ?></td>
                    <td data-label="Username"><?= htmlspecialchars($u['username']) ?></td>
                    <td data-label="NIS"><?= htmlspecialchars($u['nis']) ?></td>
                    <td data-label="Rayon"><?= htmlspecialchars($u['rayon']) ?></td>
                    <td data-label="Alamat"><?= htmlspecialchars($u['alamat']) ?></td>
                    <td data-label="Aksi" class="action">
                        <a href="edit_user.php?id=<?= $u['id'] ?>" style="color:#facc15;">✏</a>
                        <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Yakin hapus?')" style="color:#ef4444;">🗑</a>
                    </td>
                </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr>
                    <td colspan="7" class="empty">Tidak ada data siswa</td>
                </tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>

</div>

</body>
</html>