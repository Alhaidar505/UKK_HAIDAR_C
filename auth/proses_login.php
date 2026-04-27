<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// validasi kosong
if(empty($username) || empty($password)){
    echo "<script>
        alert('Username dan password wajib diisi!');
        window.location='../login.php';
    </script>";
    exit;
}

// ambil user
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

// user tidak ditemukan
if(!$user){
    echo "<script>
        alert('Username tidak ditemukan!');
        window.location='../login.php';
    </script>";
    exit;
}

// ===============================
// CEK PASSWORD (AMAN + FALLBACK MD5)
// ===============================
$passValid = false;

// jika pakai password_hash (baru)
if(password_verify($password, $user['password'])){
    $passValid = true;
}
// fallback jika masih MD5 (lama)
elseif(md5($password) == $user['password']){
    $passValid = true;

    // upgrade otomatis ke hash baru
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET password='$newHash' WHERE id='".$user['id']."'");
}

if(!$passValid){
    echo "<script>
        alert('Password salah!');
        window.location='../auth/login.php';
    </script>";
    exit;
}

// SESSION
$_SESSION['user'] = [
    'id'       => $user['id'],
    'nama'     => $user['nama'],
    'username' => $user['username'],
    'role'     => $user['role'],
    'nis'      => $user['nis'] ?? '',
    'rayon'    => $user['rayon'] ?? '',
    'alamat'   => $user['alamat'] ?? ''
];

// REDIRECT ROLE
switch($user['role']){
    case 'admin':
        header("Location: ../admin/dashboard.php");
        break;

    case 'petugas':
        header("Location: ../petugas/dashboard.php");
        break;

    case 'peminjam':
        header("Location: ../siswa/dashboard.php");
        break;

    default:
        echo "<script>
            alert('Role tidak valid!');
            window.location='../login.php';
        </script>";
        break;
}
exit;
?>