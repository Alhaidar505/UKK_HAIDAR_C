<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Petugas</title>

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

/* HEADER */
.header{
    position:sticky;
    top:0;
    z-index:10;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    background:#111827;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

.header h2{
    font-size:18px;
}

.logout{
    padding:8px 14px;
    background:#ef4444;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:13px;
    transition:0.2s;
}

.logout:hover{
    background:#dc2626;
    transform:scale(1.05);
}

/* CONTAINER */
.container{
    max-width:1100px;
    margin:auto;
    padding:25px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
    gap:20px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    padding:25px;
    border-radius:16px;
    text-align:center;
    transition:0.25s;
    backdrop-filter: blur(10px);
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.12);
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

.icon{
    font-size:40px;
    margin-bottom:10px;
}

.title{
    font-size:16px;
    font-weight:600;
    margin-bottom:5px;
}

.desc{
    font-size:13px;
    color:#94a3b8;
}

/* LINK */
a{
    text-decoration:none;
    color:white;
}

/* MOBILE */
@media(max-width:600px){
    .header h2{
        font-size:16px;
    }

    .container{
        padding:15px;
    }
}
</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>📌 Dashboard Petugas</h2>
    <a href="../auth/logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <div class="grid">

        <!-- PENGAJUAN -->
        <a href="pengajuan.php">
            <div class="card">
                <div class="icon">📥</div>
                <div class="title">Pengajuan Peminjaman</div>
                <div class="desc">Verifikasi permintaan siswa</div>
            </div>
        </a>

        <!-- RIWAYAT -->
        <a href="riwayat.php">
            <div class="card">
                <div class="icon">📄</div>
                <div class="title">Riwayat Peminjaman</div>
                <div class="desc">Struk & histori peminjaman</div>
            </div>
        </a>

    </div>

</div>

</body>
</html>