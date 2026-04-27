<?php
include '../../config/koneksi.php';

// ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

// ambil data buku berdasarkan id
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id='$id'");
$b = mysqli_fetch_assoc($data);

// update data
if (isset($_POST['submit'])) {

    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $penerbit  = $_POST['penerbit'];
    $tahun     = $_POST['tahun'];
    $stok      = $_POST['stok'];
    $harga     = $_POST['harga'];
    $kategori_id = $_POST['kategori_id'];

    mysqli_query($conn, "UPDATE buku SET 
        judul='$judul',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun='$tahun',
        stok='$stok',
        harga='$harga',
        kategori_id='$kategori_id'
        WHERE id='$id'
    ");

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Buku</title>

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
</style>

</head>
<body>

<div class="card">

    <h2>✏️ Edit Buku</h2>

    <form method="POST">

        <input type="text" name="judul" value="<?= $b['judul'] ?>" required>

        <input type="text" name="penulis" value="<?= $b['penulis'] ?>" required>

        <input type="text" name="penerbit" value="<?= $b['penerbit'] ?>" required>

        <input type="number" name="tahun" value="<?= $b['tahun'] ?>" required>

        <input type="number" name="stok" value="<?= $b['stok'] ?>" required>

        <input type="number" name="harga" value="<?= $b['harga'] ?>" required>

        <select name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while($k = mysqli_fetch_assoc($kategori)) { ?>
                <option value="<?= $k['id'] ?>"
                    <?php if($k['id'] == $b['kategori_id']) echo 'selected'; ?>>
                    <?= $k['nama_kategori'] ?>
                </option>
            <?php } ?>
        </select>

        <button name="submit">Update Buku</button>

    </form>

    <a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>