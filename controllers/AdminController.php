<?php

namespace controller;

use models\User;

class AdminController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function loginAdmin() {
        session_start();

        $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password']) && $user['isAdmin']) {
            $_SESSION['admin'] = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'isAdmin' => $user['isAdmin']
            ];

            $_SESSION['message'] = 'Login bem-sucedido.';
            $_SESSION['message_type'] = 'success';
            header('Location: /dashboard/home');
            exit();
        } else {
            $_SESSION['message'] = 'E-mail ou senha, incorretos.';
            $_SESSION['message_type'] = 'error';
            header('Location: /dashboard/login');
            exit();
        }
    }
}

?>
