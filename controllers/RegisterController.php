<?php

namespace controller;

use models\User;

class RegisterController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function showForm() {
        $this->render('cadastrar');
    }

    public function registerUser() {
        $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = !empty($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : null;
        $password = !empty($_POST['password']) ? password_hash(htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'), PASSWORD_BCRYPT) : '';
        $phone = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
        $cpf = !empty($_POST['cpf']) ? htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8') : null;
        $age = !empty($_POST['age']) ? htmlspecialchars($_POST['age'], ENT_QUOTES, 'UTF-8') : null;
        $cep = !empty($_POST['cep']) ? htmlspecialchars($_POST['cep'], ENT_QUOTES, 'UTF-8') : '';
        $rua = !empty($_POST['rua']) ? htmlspecialchars($_POST['rua'], ENT_QUOTES, 'UTF-8') : '';
        $number_house = !empty($_POST['number_house']) ? htmlspecialchars($_POST['number_house'], ENT_QUOTES, 'UTF-8') : '';
        $bairro = !empty($_POST['bairro']) ? htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8') : '';
        $cidade = !empty($_POST['cidade']) ? htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8') : '';
        $estado = !empty($_POST['estado']) ? htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8') : '';

        $addressParts = [];
        if ($cep) $addressParts[] = "cep: $cep";
        if ($rua) $addressParts[] = "rua: $rua";
        if ($number_house) $addressParts[] = "número: $number_house";
        if ($bairro) $addressParts[] = "bairro: $bairro";
        if ($cidade) $addressParts[] = "cidade: $cidade";
        if ($estado) $addressParts[] = "estado: $estado";
        $address = implode(', ', $addressParts);

        if ($this->userModel->getUserByPhone($phone)) {
            $_SESSION['message'] = 'Esse telefone já está em uso.';
            $_SESSION['message_type'] = 'error';
            header('Location: /cadastrar');
            exit();
        }

        $image_user = 'user-image.png'; 
        if (!empty($_FILES['image_user']['name'])) {
            $targetDir = __DIR__ . '/../public/images/';
            $imageName = time() . '_' . basename($_FILES['image_user']['name']);
            $targetFilePath = $targetDir . $imageName;

            if (move_uploaded_file($_FILES['image_user']['tmp_name'], $targetFilePath)) {
                $image_user = $imageName;
            }
        }

        $isAdmin = false;
        $createdAt = date('Y-m-d H:i:s');
        $updatedAt = date('Y-m-d H:i:s');

        try {
            $this->userModel->createUser($name, $email, $password, $phone, $cpf, $age, $address, $image_user, $isAdmin, $createdAt, $updatedAt);

            $_SESSION['user'] = [
                'name' => $name,
                'phone' => $phone,
                'image_user' => $image_user
            ];

            $_SESSION['message'] = 'Usuário registrado com sucesso.';
            $_SESSION['message_type'] = 'success';
            header('Location: /cadastrar');
            exit();
        } catch (\Exception $e) {
            $_SESSION['message'] = 'Erro ao registrar usuário.';
            $_SESSION['message_type'] = 'error';
            header('Location: /cadastrar');
            exit();
        }
    }


    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }
}

?>
