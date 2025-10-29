<?php
namespace models;

use PDO;

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($name, $email, $password, $phone, $cpf, $age, $address, $image_user, $isAdmin, $createdAt, $updatedAt) { 
        $stmt = $this->pdo->prepare('
        INSERT INTO users (name, email, password, phone, cpf, age, address, image_user, isAdmin, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $password, $phone, $cpf, $age, $address, $image_user, $isAdmin, $createdAt, $updatedAt]);
    }    

    public function getUserByPhone($phone) {
        $phone = str_replace(') ', ')', $phone);
    
        error_log("Buscando telefone: " . $phone);
    
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE phone = ?');
        $stmt->execute([$phone]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            error_log("Usuário encontrado: " . print_r($user, true));
        } else {
            error_log("Usuário não encontrado.");
        }
    
        return $user;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function getAllUsers() {
        $stmt = $this->pdo->query('SELECT * FROM users ORDER BY id ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function getFilteredUsers($filters) {
        $query = 'SELECT * FROM users WHERE 1=1';
        $params = [];

        if (!empty($filters['name'])) {
            $query .= ' AND name LIKE ?';
            $params[] = '%' . $filters['name'] . '%';
        }

        if (!empty($filters['phone'])) {
            $query .= ' AND phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }

        if (!empty($filters['cpf'])) {
            $query .= ' AND cpf LIKE ?';
            $params[] = '%' . $filters['cpf'] . '%';
        }

        $query .= ' ORDER BY id ASC';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUsers($filters = []) {
        $query = 'SELECT COUNT(*) FROM users WHERE 1=1';
        $params = [];
    
        if (!empty($filters['name'])) {
            $query .= ' AND name LIKE ?';
            $params[] = '%' . $filters['name'] . '%';
        }
    
        if (!empty($filters['phone'])) {
            $query .= ' AND phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
    
        if (!empty($filters['cpf'])) {
            $query .= ' AND cpf LIKE ?';
            $params[] = '%' . $filters['cpf'] . '%';
        }
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getUsersByPage($perPage, $offset, $filters = []) {
        $query = 'SELECT * FROM users WHERE 1=1';
        $params = [];
    
        if (!empty($filters['name'])) {
            $query .= ' AND name LIKE ?';
            $params[] = '%' . $filters['name'] . '%';
        }
    
        if (!empty($filters['phone'])) {
            $query .= ' AND phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
    
        if (!empty($filters['cpf'])) {
            $query .= ' AND cpf LIKE ?';
            $params[] = '%' . $filters['cpf'] . '%';
        }
    
        $query .= ' ORDER BY id ASC LIMIT ' . (int)$perPage . ' OFFSET ' . (int)$offset;
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    
    public function updateUser($data) {
        $sql = "UPDATE users SET
            name = :name,
            email = :email,
            password = :password,
            phone = :phone,
            cpf = :cpf,
            age = :age,
            address = :address,
            image_user = :image_user,
            isAdmin = :isAdmin,
            created_at = :created_at,
            updated_at = :updated_at
        WHERE id = :id";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], \PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $data['cpf'], \PDO::PARAM_STR);
        $stmt->bindParam(':age', $data['age'], \PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], \PDO::PARAM_STR);
        $stmt->bindParam(':image_user', $data['image_user'], \PDO::PARAM_STR);
        $stmt->bindParam(':isAdmin', $data['isAdmin'], \PDO::PARAM_BOOL);
        $stmt->bindParam(':created_at', $data['created_at'], \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $data['updated_at'], \PDO::PARAM_STR);
    
        $stmt->execute();
    }
    
  
    
}
?>



