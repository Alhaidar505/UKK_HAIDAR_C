<?php

require_once '../../config/koneksi.php';

/* =========================
   QUERY DATA
========================= */
$query = mysqli_query($conn, "
    SELECT 
        peminjaman.*,
        users.username,
        buku.judul
    FROM peminjaman
    JOIN users ON peminjaman.user_id = users.id
    JOIN buku ON peminjaman.buku_id = buku.id
    WHERE peminjaman.status = 'menunggu'
    ORDER BY peminjaman.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pengajuan Peminjaman</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#0f172a;
    color:#fff;
}

/* =========================
   CONTAINER
========================= */
.container{
    padding:30px;
}

/* BACK BUTTON */
.back{
    display:inline-block;
    margin-bottom:15px;
    color:#38bdf8;
    text-decoration:none;
}

/* =========================
   TABLE
========================= */
table{
    width:100%;
    border-collapse:collapse;
    background:#1e293b;
    border-radius:12px;
    overflow:hidden;
}

th, td{
    padding:12px;
    font-size:13px;
    border-bottom:1px solid #334155;
}

th{
    background:#0b1220;
    color:#94a3b8;
    text-align:left;
}

/* =========================
   BUTTON
========================= */
.btn{
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:12px;
    display:inline-block;
    margin-right:5px;
}

.btn-accept{
    background:#22c55e;
    color:#fff;
}

.btn-reject{
    background:#ef4444;
    color:#fff;
}

/* HOVER EFFECT */
.btn:hover{
    opacity:0.85;
}
</style>

</head>

<body>

<div class="container">

    <a href="../dashboard.php" class="back">← Kembali</a>

    <h2>📥 Pengajuan Peminjaman</h2>

    <table>

        <thead>
            <tr>
                <th>User</th>
                <th>Buku</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if (mysqli_num_rows($query) > 0): ?>
            <?php while ($d = mysqli_fetch_assoc($query)) { ?>

            <tr>
                <td><?= $d['username'] ?></td>
                <td><?= $d['judul'] ?></td>

                <td>
                    <a class="btn btn-accept" href="terima.php?id=<?= $d['id'] ?>">Setujui</a>
                    <a class="btn btn-reject" href="tolak.php?id=<?= $d['id'] ?>">Tolak</a>
                </td>
            </tr>

            <?php } ?>
        <?php else: ?>

            <tr>
                <td colspan="3" style="text-align:center; color:#94a3b8;">
                    Tidak ada pengajuan peminjaman
                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>
</html>