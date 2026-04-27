<?php
class AdminController extends Controller {
    public function dashboard(){
        session_start();
        if($_SESSION['user']['role'] != 'admin'){
            die("Akses ditolak!");
        }

        $this->view('admin','dashboard');
    }
}