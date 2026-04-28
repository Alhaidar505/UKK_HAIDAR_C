<?php
function simpan_log($conn, $user_id, $nama, $role, $aktivitas){
    mysqli_query($conn, "
        INSERT INTO logs (user_id, nama_user, role, aktivitas)
        VALUES ('$user_id', '$nama', '$role', '$aktivitas')
    ");
}