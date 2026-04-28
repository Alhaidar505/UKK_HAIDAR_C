<?php
session_start();
include '../../config/koneksi.php';

/* 
   AMBIL DATA LOGS
 */
$query = mysqli_query($conn, "
    SELECT * FROM logs
    ORDER BY waktu DESC
    LIMIT 100
");

$logs = [];
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $logs[] = $row;
    }
}

/* 
   FORMAT WAKTU
 */
function formatWaktu($waktu)
{
    return date('d-m-Y H:i', strtotime($waktu));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logs Sistem</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:linear-gradient(135deg,#0f172a,#020617);
    color:white;
    min-height:100vh;
}

/* CONTAINER */
.container{
    padding:25px;
    max-width:1200px;
    margin:auto;
}

/* HEADER */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.btn-back{
    padding:10px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    color:white;
    transition:0.3s;
}

.btn-back:hover{
    transform:translateX(-3px);
    background:rgba(255,255,255,0.12);
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
    min-width:800px;
    background:rgba(30,41,59,0.85);
    border-radius:12px;
    overflow:hidden;
}

th, td{
    padding:14px;
    font-size:13px;
    border-bottom:1px solid rgba(255,255,255,0.08);
    text-align:left;
}

th{
    color:#94a3b8;
    background:#0b1220;
}

tr:hover{
    background:rgba(255,255,255,0.04);
}

/* ROLE */
.badge{
    display:inline-block;
    padding:4px 8px;
    border-radius:6px;
    font-size:10px;
    margin-top:5px;
    text-transform:capitalize;
}

.admin{ background:#ef4444; }
.petugas{ background:#3b82f6; }
.peminjam{ background:#22c55e; }

/* EMPTY */
.empty{
    text-align:center;
    padding:20px;
    color:#94a3b8;
}

/* RESPONSIVE */
@media(max-width:768px){
    .container{ padding:15px; }

    table{ min-width:100%; }

    th,td{
        font-size:12px;
        padding:10px;
    }
}

@media(max-width:600px){

    table, thead, tbody, tr, td{
        display:block;
        width:100%;
    }

    thead{
        display:none;
    }

    tr{
        background:rgba(30,41,59,0.9);
        margin-bottom:15px;
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
        color:#94a3b8;
        font-weight:600;
    }
}
</style>
</head>

<body>

<div class="container">

<div class="top-bar">
    <a href="../dashboard.php" class="btn-back">← Kembali</a>
</div>

<div class="table-wrapper">

<table>

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Aktivitas</th>
    <th>Waktu</th>
</tr>

<?php if(count($logs) > 0): ?>
    <?php $no = 1; foreach($logs as $log): ?>
    <tr>

        <td data-label="No"><?= $no++ ?></td>

        <td data-label="Nama">
            <?= htmlspecialchars($log['nama_user']) ?>
            <br>
            <span class="badge <?= htmlspecialchars($log['role']) ?>">
                <?= htmlspecialchars($log['role']) ?>
            </span>
        </td>

        <td data-label="Aktivitas">
            <?= htmlspecialchars($log['aktivitas']) ?>
        </td>

        <td data-label="Waktu">
            <?= formatWaktu($log['waktu']) ?>
        </td>

    </tr>
    <?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="4" class="empty">Belum ada aktivitas</td>
</tr>
<?php endif; ?>

</table>

</div>

</div>

</body>
</html>