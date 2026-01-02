<?php
require_once '../config/Database.php';
require_once '../models/User.php';
// require_once '../views/read.php';
class UserController
{
    private $model;
    public function __construct()
    {
        $db = (new Database())->getConnection();
        $this->model = new User($db);
    }
    public function akun()
    {
        $users = $this->model->readAll();
        include '../views/read_data.php';
    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->create($_POST);
            header('Location: index.php?action=akun');
            exit;
        } else {
            include '../views/create.php';
        }
    }
    public function edit($id)
    {
        $user = $this->model->find($id);
        include '../views/update.php';
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->update($id, $_POST);
            header('Location: index.php?action=akun');
            exit;
        }
    }
    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: index.php?action=akun');
        exit;
    }
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->model->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                // Redirect berdasarkan level
                switch ($user['level']) {
                    case 'admin':
                        header('Location: ../views/dashboard_admin.php');
                        break;
                    case 'operator':
                        header('Location:  ../views/dashboard_operator.php');
                        break;
                    case 'user':
                        header('Location: ../views/dashboard_user.php');
                        break;
                    default:
                        header('Location: index.php');
                }
                exit;
            } else {
                $error = "Username atau password salah!";
            }
        }
        include '../views/login.php';
    }
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset(); // Hapus semua variabel session
        session_destroy(); // Hancurkan session
        header('Location: ../views/login.php');
        exit;
    }
}
