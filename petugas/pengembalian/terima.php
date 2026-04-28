<?php

require_once '../../config/koneksi.php';

/* =========================
   VALIDASI ID
========================= */
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan");
}

/* =========================
   AMBIL DATA PEMINJAMAN
========================= */
$query = mysqli_query($conn, "
    SELECT * FROM peminjaman WHERE id='$id' LIMIT 1
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}

/* =========================
   VARIABEL
========================= */
$buku_id    = $data['buku_id'];
$tgl_pinjam = $data['tanggal_pinjam'];

/* =========================
   HITUNG DENDA
   aturan:
   - maksimal 7 hari
   - lewat = 1000/hari
========================= */
$pinjam = new DateTime($tgl_pinjam);
$now    = new DateTime();

$selisih_hari = $pinjam->diff($now)->days;

$batas_pinjam = 7;
$denda = 0;

if ($selisih_hari > $batas_pinjam) {
    $denda = ($selisih_hari - $batas_pinjam) * 1000;
}

/* =========================
   UPDATE PEMINJAMAN
========================= */
mysqli_query($conn, "
    UPDATE peminjaman 
    SET 
        status='dikembalikan',
        tanggal_kembali=NOW(),
        denda='$denda',
        denda_status='terhitung'
    WHERE id='$id'
");

/* =========================
   UPDATE STOK BUKU
========================= */
mysqli_query($conn, "
    UPDATE buku 
    SET stok = stok + 1 
    WHERE id='$buku_id'
");

/* =========================
   RESPONSE
========================= */
echo "<script>
    alert('Pengembalian berhasil diproses. Denda: Rp " . number_format($denda, 0, ',', '.') . "');
    window.location='pengembalian.php';
</script>";
