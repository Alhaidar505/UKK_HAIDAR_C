<?php
session_start();
include '../../config/koneksi.php';
include '../../config/logs.php';

$kategori = mysqli_query($conn, "SELECT * FROM kategori");

if (isset($_POST['submit'])) {

   // AUTO BARCODE
   $barcode  = 'BK' . time();

   $judul       = $_POST['judul'];
   $penulis     = $_POST['penulis'];
   $penerbit    = $_POST['penerbit'];
   $tahun       = $_POST['tahun'];
   $stok        = (int) $_POST['stok'];
   $kategori_id = $_POST['kategori_id'];

   // =========================
   // VALIDASI STOK (TIDAK BOLEH MINUS)
   // =========================
   if ($stok < 0) {
       echo "<script>
           alert('❌ Stok tidak boleh kurang dari 0!');
           window.history.back();
       </script>";
       exit;
   }

   // HARGA
   $harga_input = $_POST['harga']; 
   $harga = $harga_input * 1000;

   // =========================
   // COVER UPLOAD (SAFE)
   // =========================
   $namaFileBaru = null;

   if (!empty($_FILES['cover']['name'])) {
       $cover = $_FILES['cover']['name'];
       $tmp   = $_FILES['cover']['tmp_name'];

       $ext = pathinfo($cover, PATHINFO_EXTENSION);
       $namaFileBaru = time() . "." . $ext;

       move_uploaded_file($tmp, "../../uploads/" . $namaFileBaru);
   }

   // INSERT
   $query = mysqli_query($conn, "INSERT INTO buku 
   (barcode, judul, penulis, penerbit, tahun, stok, harga, cover, kategori_id) 
   VALUES 
   ('$barcode','$judul','$penulis','$penerbit','$tahun','$stok','$harga','$namaFileBaru','$kategori_id')");

   // LOG
   if($query){
        simpan_log(
            $conn,
            $_SESSION['user']['id'],
            $_SESSION['user']['nama'],
            $_SESSION['user']['role'],
            "Menambahkan buku: $judul (Stok: $stok)"
        );
   }

   header("Location: index.php");
   exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Buku</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.card{
    width:100%;
    max-width:460px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:18px;
    padding:25px;
    backdrop-filter:blur(12px);
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:18px;
    font-size:20px;
}

/* INPUT */
input, select{
    width:100%;
    padding:12px;
    margin:8px 0;
    border-radius:10px;
    border:none;
    outline:none;
    background:rgba(255,255,255,0.1);
    color:white;
    font-size:14px;
}

input::placeholder{
    color:#94a3b8;
}

select option{
    color:black;
}

/* FILE */
input[type="file"]{
    background:transparent;
    padding:8px;
}

/* INFO */
.info-harga{
    font-size:11px;
    color:#94a3b8;
    text-align:center;
    margin-top:-5px;
    margin-bottom:10px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#38bdf8,#22d3ee);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
}

/* BACK */
.back{
    display:block;
    text-align:center;
    margin-top:15px;
    color:#38bdf8;
    text-decoration:none;
    font-size:13px;
}

/* RESPONSIVE */
@media(max-width:480px){
    .card{
        padding:18px;
    }

    h2{
        font-size:18px;
    }
}
</style>
</head>

<body>

<div class="card">

<h2>📚 Tambah Buku</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="judul" placeholder="Judul Buku" required>
<input type="text" name="penulis" placeholder="Penulis" required>
<input type="text" name="penerbit" placeholder="Penerbit" required>
<input type="number" name="tahun" placeholder="Tahun Terbit" required>

<!-- STOK (ANTI MINUS) -->
<input type="number" name="stok" placeholder="Stok Buku" min="0" required>

<!-- COVER -->
<input type="file" name="cover" accept="image/*">

<input type="number" name="harga" placeholder="Harga (ribu)" required>

<div class="info-harga">
💡 Input <b>100</b> = Rp <b>100.000</b>
</div>

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

<a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>