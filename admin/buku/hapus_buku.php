<?php
include '../../config/koneksi.php';
mysqli_query($conn, "DELETE FROM buku WHERE id='$_GET[id]'");
header("Location: index.php");