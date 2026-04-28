<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    color:#fff;
}

/* =========================
   HEADER
========================= */
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

/* =========================
   BUTTON
========================= */
.btn{
    padding:8px 14px;
    border-radius:10px;
    font-size:13px;
    text-decoration:none;
    transition:0.2s;
    display:inline-block;
}

.btn-danger{
    background:#ef4444;
    color:#fff;
}

.btn-danger:hover{
    background:#dc2626;
    transform:scale(1.05);
}

/* =========================
   CONTAINER
========================= */
.container{
    max-width:1100px;
    margin:auto;
    padding:25px;
}

/* =========================
   GRID
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
    gap:20px;
}

/* =========================
   CARD
========================= */
.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    transition:0.25s;
    backdrop-filter:blur(10px);
}

/* LINK */
.card-link{
    display:block;
    padding:25px;
    text-decoration:none;
    color:#fff;
    text-align:center;
}

/* HOVER EFFECT */
.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.12);
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* =========================
   CARD CONTENT
========================= */
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

/* =========================
   RESPONSIVE
========================= */
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
<header class="header">
    <h2>📌 Dashboard Petugas</h2>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</header>

<!-- CONTENT -->
<main class="container">

    <section class="grid">

        <!-- PENGAJUAN -->
        <div class="card">
            <a href="pengajuan/pengajuan.php" class="card-link">
                <div class="icon">📥</div>
                <div class="title">Pengajuan Peminjaman</div>
                <div class="desc">Verifikasi permintaan siswa</div>
            </a>
        </div>

        <!-- PENGEMBALIAN -->
        <div class="card">
            <a href="pengembalian/index.php" class="card-link">
                <div class="icon">📤</div>
                <div class="title">Pengembalian Siswa</div>
                <div class="desc">Validasi pengembalian buku</div>
            </a>
        </div>

        <!-- PEMBAYARAN -->
        <div class="card">
            <a href="pembayaran/index.php" class="card-link">
                <div class="icon">💳</div>
                <div class="title">Pembayaran Siswa</div>
                <div class="desc">Struk & histori pembayaran</div>
            </a>
        </div>

        <!-- RIWAYAT -->
        <div class="card">
            <a href="riwayat.php" class="card-link">
                <div class="icon">📄</div>
                <div class="title">Riwayat Peminjaman</div>
                <div class="desc">Data histori peminjaman</div>
            </a>
        </div>

    </section>

</main>

</body>
</html>