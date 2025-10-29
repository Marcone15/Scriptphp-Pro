<?php

namespace controller;

use models\User;

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function showUsers() {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $filters = [
            'name' => $_GET['name'] ?? '',
            'phone' => $_GET['phone'] ?? '',
            'cpf' => $_GET['cpf'] ?? ''
        ];

        $users = $this->userModel->getUsersByPage($perPage, $offset, $filters);
        $totalUsers = $this->userModel->getTotalUsers($filters);
        $totalPages = ceil($totalUsers / $perPage);

        $this->renderDashboard('user', [
            'users' => $users,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }

    public function deleteUser() {
        $id = $_POST['id'];
        $this->userModel->deleteUser($id);
        header('Location: /dashboard/users');
    }
    
    private function renderDashboard($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }

    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $_POST['password_old'];
            $phone = $_POST['phone'];
            $cpf = $_POST['cpf'];
            $age = $_POST['age'];
            $address = $_POST['address'];
            $createdAt = $_POST['created_at'];
            $updatedAt = date('Y-m-d H:i:s');
            $isAdmin = isset($_POST['is_admin']) ? $_POST['is_admin'] : false;
    
            $imageUser = $_POST['img-user-old'];
            if (isset($_FILES['image_user']) && $_FILES['image_user']['error'] == 0) {
                $imageUser = $this->processUserImage($_FILES['image_user']);
            }
    
            $this->userModel->updateUser([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'cpf' => $cpf,
                'age' => $age,
                'address' => $address,
                'image_user' => $imageUser,
                'isAdmin' => $isAdmin,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
    
            header('Location: /dashboard/users');
            exit();
        }
    }
    
    
    private function processUserImage($image) {
        $imageName = uniqid() . '-' . basename($image['name']);
        $targetFilePath = __DIR__ . '/../public/images/' . $imageName;
    
        if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
            return $imageName;
        }
    
        return 'no-image.png';
    }
    
}
?>  


<?php


