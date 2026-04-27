<?php
include '../config/koneksi.php';

$id = $_GET['id'];

if(isset($_POST['submit'])){

    $status  = $_POST['status'];
    $catatan = $_POST['catatan'];

    $today = date('Y-m-d');

    // =========================
    // LOGIKA TELAT
    // =========================
    if($status == 'telat'){
        mysqli_query($conn,"
            UPDATE peminjaman 
            SET status='telat',
                tanggal_kembali='$today',
                catatan='$catatan'
            WHERE id='$id'
        ");
    }
    else{
        // rusak / hilang
        mysqli_query($conn,"
            UPDATE peminjaman 
            SET status='$status',
                catatan='$catatan'
            WHERE id='$id'
        ");
    }

    echo "<script>
    alert('Status berhasil diubah!');
    window.location='dashboard.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Indikasi Peminjaman</title>

<style>
body{
    font-family:Segoe UI;
    background:#0f172a;
    color:white;
}

.box{
    width:420px;
    margin:80px auto;
    background:#1e293b;
    padding:20px;
    border-radius:12px;
}

h3{text-align:center}

select,textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    border:none;
    border-radius:8px;
}

button{
    width:100%;
    margin-top:15px;
    padding:10px;
    background:#ef4444;
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    opacity:0.8;
}

</style>

</head>

<body>

<div class="box">

<h3>Pelanggaran Peminjaman</h3>

<form method="POST">

    <label>Status Pelanggaran</label>

    <select name="status" required>
        <option value="telat">Telat (Denda 500 perhari)</option>
        <option value="rusak">Rusak (50% harga buku)</option>
        <option value="hilang">Hilang (100% ganti buku)</option>
    </select>
    <button type="submit" name="submit">Simpan Perubahan</button>

</form>

</div>

</body>
</html>