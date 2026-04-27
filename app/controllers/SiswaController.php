<?php
class SiswaController extends Controller {
    public function dashboard(){
        session_start();
        if($_SESSION['user']['role'] != 'siswa'){
            die("Akses ditolak!");
        }

        $this->view('siswa','dashboard');
    }
}