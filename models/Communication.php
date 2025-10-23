<?php

namespace models;

class Communication {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCommunications() {
        $stmt = $this->pdo->query('SELECT * FROM communications ORDER BY id DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addCommunication($communication) {
        $stmt = $this->pdo->prepare('INSERT INTO communications (communication, created_at, updated_at) VALUES (?, NOW(), NOW())');
        $stmt->execute([$communication]);
    }

    public function updateCommunication($id, $communication) {
        $stmt = $this->pdo->prepare('UPDATE communications SET communication = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$communication, $id]);
    }

    public function deleteCommunication($id) {
        $stmt = $this->pdo->prepare('DELETE FROM communications WHERE id = ?');
        $stmt->execute([$id]);
    }
}
?>
