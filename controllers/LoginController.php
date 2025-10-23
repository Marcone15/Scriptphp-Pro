<?php

namespace controller;

use models\User;

class LoginController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function showForm() {
        $this->render('login');
    }

    public function loginUser() {
        session_start();
    
        if (empty($_POST['phone'])) {
            $_SESSION['message'] = 'O campo de telefone é obrigatório.';
            $_SESSION['message_type'] = 'error';
            header('Location: /login');
            exit();
        }
    
        $phone = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');
    
        $user = $this->userModel->getUserByPhone($phone);
    
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'image_user' => $user['image_user']
            ];
    
            $_SESSION['message'] = 'Login bem-sucedido.';
            $_SESSION['message_type'] = 'success';
            header('Location: /');
            exit();
        } else {
            $_SESSION['message'] = 'Telefone ou senha incorretos.';
            $_SESSION['message_type'] = 'error';
            header('Location: /login');
            exit();
        }
    }
    

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }
}

?>
