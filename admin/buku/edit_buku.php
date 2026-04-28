<?php
session_start();
include '../../config/koneksi.php';
include '../../config/logs.php';

// ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

// ambil data buku
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM buku WHERE id='$id'");
$b = mysqli_fetch_assoc($data);

// cover lama
$cover_lama = $b['cover'];

if(isset($_POST['submit'])){

    $judul       = $_POST['judul'];
    $penulis     = $_POST['penulis'];
    $penerbit    = $_POST['penerbit'];
    $tahun       = $_POST['tahun'];
    $stok        = (int) $_POST['stok'];
    $harga       = $_POST['harga'];
    $kategori_id = $_POST['kategori_id'];

    /* ======================
       VALIDASI STOK (TIDAK BOLEH MINUS)
    ====================== */
    if ($stok < 0) {
        echo "<script>
            alert('❌ Stok tidak boleh kurang dari 0!');
            window.history.back();
        </script>";
        exit;
    }

    /* ======================
       UPLOAD COVER
    ====================== */
    $cover = $cover_lama;

    if(!empty($_FILES['cover']['name'])){

        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $nama_file = time().'_cover.'.$ext;
        $tmp = $_FILES['cover']['tmp_name'];

        move_uploaded_file($tmp, "../../uploads/".$nama_file);

        $cover = $nama_file;
    }

    $update = mysqli_query($conn, "UPDATE buku SET 
        judul='$judul',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun='$tahun',
        stok='$stok',
        harga='$harga',
        kategori_id='$kategori_id',
        cover='$cover'
        WHERE id='$id'
    ");

    if($update){
        simpan_log(
            $conn,
            $_SESSION['user']['id'],
            $_SESSION['user']['nama'],
            $_SESSION['user']['role'],
            "Mengedit buku: $judul (ID: $id)"
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
<title>Edit Buku</title>

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
    max-width:500px;
    padding:25px;
    border-radius:18px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.1);
    backdrop-filter:blur(12px);
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

/* TITLE */
h2{
    text-align:center;
    margin-bottom:20px;
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

/* LABEL */
label{
    font-size:13px;
    color:#cbd5e1;
}

/* COVER PREVIEW */
.preview{
    margin:10px 0;
    text-align:center;
}

.preview img{
    width:90px;
    border-radius:10px;
    border:2px solid rgba(255,255,255,0.2);
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    margin-top:12px;
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

<h2>✏️ Edit Buku</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="judul" value="<?= $b['judul'] ?>" required>
    <input type="text" name="penulis" value="<?= $b['penulis'] ?>" required>
    <input type="text" name="penerbit" value="<?= $b['penerbit'] ?>" required>
    <input type="number" name="tahun" value="<?= $b['tahun'] ?>" required>

    <!-- STOK (ANTI MINUS) -->
    <input type="number" name="stok" value="<?= $b['stok'] ?>" min="0" required>

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

    <!-- COVER -->
    <label>Cover Buku</label>

    <div class="preview">
        <?php if(!empty($b['cover'])) { ?>
            <img src="../../uploads/<?= $b['cover'] ?>">
        <?php } else { ?>
            <small>Tidak ada cover</small>
        <?php } ?>
    </div>

    <input type="file" name="cover" accept="image/*">

    <button name="submit">💾 Update Buku</button>

</form>

<a href="index.php" class="back">← Kembali</a>

</div>

</body>
</html>