<?php

namespace middlewares;

class AuthMiddleware {
    public function handle() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin']) || !is_array($_SESSION['admin']) || !isset($_SESSION['admin']['isAdmin']) || (bool) $_SESSION['admin']['isAdmin'] !== true) {
            $_SESSION['message'] = 'Você não tem permissão para acessar essa página';
            $_SESSION['message_type'] = 'error';

            header('Location: /dashboard/login');
            exit();
        }

        if (!isset($_SESSION['regenerated']) || $_SESSION['regenerated'] < time() - 300) {
            session_regenerate_id(true);
            $_SESSION['regenerated'] = time();
        }
    }
}

?>
