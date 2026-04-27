<?php
class AuthController extends Controller {

    public function index(){
        $this->view('auth', 'login');
    }

    public function login(){
        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = $this->model('User');
        $user = $userModel->login($username, $password);

        if($user){
            $_SESSION['user'] = $user;

            // redirect sesuai role
            if($user['role'] == 'admin'){
                header("Location: /UKK_HAIDAR_C/public/admin/dashboard");
                exit;
            }

            if($user['role'] == 'petugas'){
                header("Location: /UKK_HAIDAR_C/public/petugas/dashboard");
                exit;
            }

            if($user['role'] == 'siswa'){
                header("Location: /UKK_HAIDAR_C/public/siswa/dashboard");
                exit;
            }

        }else{
            echo "<script>
                alert('Login gagal');
                window.location='/UKK_HAIDAR_C/public/auth';
            </script>";
            exit;
        }
    }

    public function logout(){
        session_start();
        session_destroy();

        header("Location: /UKK_HAIDAR_C/public/auth");
        exit;
    }
}