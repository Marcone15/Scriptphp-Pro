<?php
namespace model;

class Gateway {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllGateways() {
        $stmt = $this->pdo->prepare('SELECT * FROM gateways');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    
}
?>
