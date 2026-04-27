<?php
include '../../config/koneksi.php';

// ambil data kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_POST['submit'])) {

   // AUTO BARCODE
   $barcode  = 'BK' . time();

   $judul     = $_POST['judul'];
   $penulis   = $_POST['penulis'];
   $penerbit  = $_POST['penerbit'];
   $tahun     = $_POST['tahun'];
   $stok      = $_POST['stok'];
   
   // *** KONVERSI HARGA: 100 → 100000 ***
   $harga_input = $_POST['harga']; 
   $harga = $harga_input * 1000; // Input 100 = 100.000
   
   $kategori_id = $_POST['kategori_id'];

   mysqli_query($conn, "INSERT INTO buku 
   (barcode, judul, penulis, penerbit, tahun, stok, harga, kategori_id) 
   VALUES 
   ('$barcode','$judul','$penulis','$penerbit','$tahun','$stok','$harga','$kategori_id')");

   header("Location: index.php");
   exit;
}

// *** FUNGSI FORMAT HARGA UNTUK DISPLAY ***
function formatHargaInput($harga){
    return number_format($harga / 1000, 0, ',', '.') . 'rb';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Buku</title>

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
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    width:400px;
    padding:25px;
    border-radius:14px;
    background: rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input, select{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:10px;
    border:none;
    outline:none;
    background: rgba(255,255,255,0.1);
    color:white;
    font-size:14px;
}

input::placeholder {
    color:#94a3b8;
}

select option{
    color:black;
}

button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    background: linear-gradient(135deg,#38bdf8,#22d3ee);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform: scale(1.03);
}

.back{
    display:block;
    text-align:center;
    margin-top:15px;
    color:#38bdf8;
    text-decoration:none;
}

.info-harga{
    font-size:11px;
    color:#94a3b8;
    text-align:center;
    margin-top:-10px;
    margin-bottom:15px;
}
</style>

</head>
<body>

<div class="card">

    <h2>📚 Tambah Buku</h2>

    <form method="POST">

        <input type="text" name="judul" placeholder="Judul Buku" required>

        <input type="text" name="penulis" placeholder="Penulis" required>

        <input type="text" name="penerbit" placeholder="Penerbit" required>

        <input type="number" name="tahun" placeholder="Tahun Terbit" min="1900" max="2025" required>

        <input type="number" name="stok" placeholder="Stok Buku" min="1" required>

        <!--  HARGA DENGAN KONVERSI AUTOMATIS -->
        <input type="number" 
               name="harga" 
               placeholder="Harga (ribu)" 
               min="1" 
               step="1"
               required>
        <div class="info-harga">
            💡 Contoh: Input <strong>100</strong> = Rp <strong>100.000</strong>
        </div>

        <!-- KATEGORI -->
        <select name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while($k = mysqli_fetch_assoc($kategori)) { ?>
                <option value="<?= $k['id'] ?>">
                    <?= $k['nama_kategori'] ?>
                </option>
            <?php } ?>
        </select>

        <button name="submit">💾 Simpan Buku</button>

    </form>

    <a href="index.php" class="back">← Kembali ke Data Buku</a>

</div>

</body>
</html>