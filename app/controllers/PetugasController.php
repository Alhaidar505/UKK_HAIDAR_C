<?php
class PetugasController extends Controller {
    public function dashboard(){
        session_start();
        if($_SESSION['user']['role'] != 'petugas'){
            die("Akses ditolak!");
        }

        $this->view('petugas','dashboard');
    }
}