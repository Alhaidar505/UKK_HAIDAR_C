<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

/* CEK ROLE */
function checkRole($role){
    if ($_SESSION['user']['role'] !== $role) {
        echo "<script>
            alert('Akses ditolak!');
            window.location='../auth/login.php';
        </script>";
        exit;
    }
}