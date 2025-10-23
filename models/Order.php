<?php 
namespace models;

use PDO;
use DateTime;
use DateTimeZone;

class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createOrder($data) {
    $timezone = new \DateTimeZone('America/Sao_Paulo');
    $now = new \DateTime('now', $timezone);
    $createdAt = $now->format('Y-m-d H:i:s');

    $expirationDate = new \DateTime($data['expiration_date'], new \DateTimeZone('UTC'));
    $expirationDate->setTimezone($timezone);
    $adjustedExpirationDate = $expirationDate->format('Y-m-d H:i:s');

    $stmt = $this->pdo->prepare('
        INSERT INTO orders (
            id_campaign, id_user, quantity, numbers, total, payment_status, pix_url,
            expiration_date, hash_order, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ');
    $stmt->execute([
        $data['id_campaign'],
        $data['id_user'],
        $data['quantity'],
        $data['numbers'],
        $data['total'],
        'pendente', 
        $data['pix_url'],
        $adjustedExpirationDate, 
        $data['hash_order'],
        $createdAt, 
        $createdAt 
    ]);

    return $this->pdo->lastInsertId();
    }

    
    

    public function getOrderByHash($hash) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE hash_order = ?');
        $stmt->execute([$hash]);
        $order = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        return $order ?: false; 
    }

    

    public function getCreatedAt($orderId) {
        $stmt = $this->pdo->prepare('SELECT created_at FROM orders WHERE id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchColumn();
    }

    public function getOrdersByPhone($phone, $limit, $offset) {
        $stmt = $this->pdo->prepare('
            SELECT orders.id, users.name, campaigns.name AS campaign_name, campaigns.image_raffle AS campaign_image_raffle, orders.hash_order, orders.payment_status, orders.created_at, orders.quantity, orders.total, orders.numbers
            FROM orders
            JOIN users ON orders.id_user = users.id
            JOIN campaigns ON orders.id_campaign = campaigns.id
            WHERE users.phone = ?
            ORDER BY orders.id DESC
            LIMIT ? OFFSET ?');
        $stmt->bindParam(1, $phone, \PDO::PARAM_STR);
        $stmt->bindParam(2, $limit, \PDO::PARAM_INT);
        $stmt->bindParam(3, $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalOrdersByPhone($phone) {
        $stmt = $this->pdo->prepare('
            SELECT COUNT(*) 
            FROM orders 
            JOIN users ON orders.id_user = users.id 
            WHERE users.phone = ?');
        $stmt->execute([$phone]);
        return $stmt->fetchColumn();
    }

    public function getTotalOrders() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM orders');
        return $stmt->fetchColumn();
    }

    public function getTotalRevenue() {
        $stmt = $this->pdo->query('SELECT SUM(REPLACE(total, ",", ".") * 1) AS total FROM orders WHERE payment_status = "pago"');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ? floatval($result['total']) : 0;
    }

    public function getAllOrders() {
        $stmt = $this->pdo->prepare('
            SELECT orders.*, users.name AS user_name, campaigns.name AS campaign_name
            FROM orders
            JOIN users ON orders.id_user = users.id
            JOIN campaigns ON orders.id_campaign = campaigns.id
            ORDER BY orders.id DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFilteredOrders($campaignId, $orderHash, $titleNumber, $clientName, $limit = null, $offset = null) {
        $query = '
            SELECT orders.*, users.name AS user_name, campaigns.name AS campaign_name
            FROM orders
            JOIN users ON orders.id_user = users.id
            JOIN campaigns ON orders.id_campaign = campaigns.id
            WHERE 1=1';
        
        $params = [];
    
        if ($campaignId) {
            $query .= ' AND orders.id_campaign = ?';
            $params[] = $campaignId;
        }
    
        if ($orderHash) {
            $query .= ' AND orders.hash_order LIKE ?';
            $params[] = '%' . $orderHash . '%';
        }
    
        if ($titleNumber) {
            $query .= ' AND FIND_IN_SET(?, REPLACE(orders.numbers, \', \', \',\'))';
            $params[] = $titleNumber;
        }
    
        if ($clientName) {
            $query .= ' AND users.name LIKE ?';
            $params[] = '%' . $clientName . '%';
        }
    
        if ($limit !== null && $offset !== null) {
            $query .= ' ORDER BY orders.id DESC LIMIT ? OFFSET ?';
            $params[] = (int) $limit;
            $params[] = (int) $offset;
        } else {
            $query .= ' ORDER BY orders.id DESC';
        }
    
        $stmt = $this->pdo->prepare($query);
    
        foreach ($params as $index => $val) {
            if (is_int($val)) {
                $stmt->bindValue($index + 1, $val, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($index + 1, $val, PDO::PARAM_STR);
            }
        }
    
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
    public function getTotalFilteredOrders($campaignId, $orderHash, $titleNumber, $clientName) {
        $query = '
            SELECT COUNT(*) 
            FROM orders
            JOIN users ON orders.id_user = users.id
            JOIN campaigns ON orders.id_campaign = campaigns.id
            WHERE 1=1';
        
        $params = [];
    
        if ($campaignId) {
            $query .= ' AND orders.id_campaign = ?';
            $params[] = $campaignId;
        }
    
        if ($orderHash) {
            $query .= ' AND orders.hash_order LIKE ?';
            $params[] = '%' . $orderHash . '%';
        }
    
        if ($titleNumber) {
            $query .= ' AND FIND_IN_SET(?, REPLACE(orders.numbers, \', \', \',\'))';
            $params[] = $titleNumber;
        }
    
        if ($clientName) {
            $query .= ' AND users.name LIKE ?';
            $params[] = '%' . $clientName . '%';
        }
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    
        return $stmt->fetchColumn();
    }
    

    public function deleteOrder($orderId) {
        $stmt = $this->pdo->prepare('DELETE FROM orders WHERE id = ?');
        $stmt->execute([$orderId]);
        return $stmt->rowCount() > 0; 
    }

    public function getOrderById($id) {
        $stmt = $this->pdo->prepare('
            SELECT orders.*, users.name AS user_name, users.phone AS user_phone, campaigns.name AS campaign_name
            FROM orders
            JOIN users ON orders.id_user = users.id
            JOIN campaigns ON orders.id_campaign = campaigns.id
            WHERE orders.id = ?
        ');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function getUserById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getOrdersByCampaignAndStatus($campaignId, $status) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id_campaign = ? AND payment_status = ?');
        $stmt->execute([$campaignId, $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderByNumber($campaignId, $number) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id_campaign = ? AND numbers LIKE ? AND payment_status = "pago"');
        $stmt->execute([$campaignId, '%' . $number . '%']);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrdersByCampaignAndDate($campaignId, $date, $status) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id_campaign = ? AND DATE(created_at) = ? AND payment_status = ?');
        $stmt->execute([$campaignId, $date, $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrder($data) {
        $sql = "UPDATE orders SET
            payment_status = :payment_status,
            quantity = :quantity,
            numbers = :numbers,
            total = :total
        WHERE id = :id";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $stmt->bindParam(':payment_status', $data['payment_status'], \PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $data['quantity'], \PDO::PARAM_INT);
        $stmt->bindParam(':numbers', $data['numbers'], \PDO::PARAM_STR);
        $stmt->bindParam(':total', $data['total'], \PDO::PARAM_STR);
    
        $stmt->execute();
    }
    
    public function updateOrderNumbers($orderId, $numbers) {
        $sql = "UPDATE orders SET numbers = :numbers WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $orderId, \PDO::PARAM_INT);
        $stmt->bindParam(':numbers', $numbers, \PDO::PARAM_STR);
        $stmt->execute();
    }
    
    public function getAllPaidNumbers($idCampaign) {
        $sql = "SELECT numbers FROM orders WHERE id_campaign = :id_campaign AND payment_status = 'pago'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_campaign', $idCampaign, \PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $allNumbers = [];
    
        foreach ($results as $result) {
            $allNumbers = array_merge($allNumbers, explode(', ', $result));
        }
    
        return $allNumbers;
    }

    public function updatePaymentStatus($id, $status) {
        $sql = "UPDATE orders SET payment_status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getExistingNumbers($campaignId) {
        $sql = "SELECT numbers FROM orders WHERE id_campaign = :campaignId AND payment_status = 'pago'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':campaignId', $campaignId, \PDO::PARAM_INT);
        $stmt->execute();

        $existingNumbers = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $numbers = explode(',', $row['numbers']);
            $existingNumbers = array_merge($existingNumbers, $numbers);
        }

        return $existingNumbers;
    }

    public function getOrderByPixUrl($pix_url) {
        $stmt = $this->pdo->prepare('
            SELECT orders.*, campaigns.name AS campaign_name, campaigns.id AS campaign_id, campaigns.price AS campaign_price, campaigns.expiration_pix AS campaign_expiration_pix, campaigns.type_raffle AS campaign_type_raffle, campaigns.draw_titles AS campaign_draw_titles,campaigns.award_titles AS campaign_award_titles, users.name AS user_name, users.cpf AS user_cpf, users.phone AS user_phone, users.email AS user_email, users.email AS user_email 
            FROM orders 
            JOIN campaigns ON orders.id_campaign = campaigns.id 
            JOIN users ON orders.id_user = users.id 
            WHERE orders.pix_url = ?
        ');
        $stmt->execute([$pix_url]);
        return $stmt->fetch();
    }  

    
    public function setPaymentStatusToPaid($pixUrl) {
        try {
            logMessage("Iniciando setPaymentStatusToPaid para pixUrl: " . $pixUrl, 'gerencianet.log');
    
            $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE pix_url = ?');
            if (!$stmt) {
                throw new Exception('Falha ao preparar a declaração SQL para buscar o pedido.');
            }
    
            $stmt->execute([$pixUrl]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$order) {
                throw new Exception('Falha ao buscar o pedido ou pedido não encontrado.');
            }
    
            logMessage("Pedido encontrado para pixUrl: " . $pixUrl . ". Status de pagamento atual: " . $order['payment_status'], 'gerencianet.log');
    
            if ($order['payment_status'] === 'pendente') {
                $updateStmt = $this->pdo->prepare('UPDATE orders SET payment_status = ? WHERE id = ?');
                if (!$updateStmt) {
                    throw new Exception('Falha ao preparar a declaração SQL para atualizar o pedido.');
                }
    
                $updateStmt->execute(['pago', $order['id']]);
    
                if ($updateStmt->rowCount() === 0) {
                    throw new Exception('Falha ao atualizar o status do pedido.');
                }
    
                logMessage("Status do pedido atualizado para 'pago' para o pedido ID: " . $order['id'], 'gerencianet.log');
            }
        } catch (Exception $e) {
            logMessage("Erro ao atualizar o status do pedido: " . $e->getMessage(), 'gerencianet.log');
        }
    }
    
    public function getExpiredPendingOrders() {
    $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE payment_status = 'pendente' AND expiration_date <= NOW()");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingOrders() {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE payment_status = ?');
        $stmt->execute(['pendente']);
        return $stmt->fetchAll();
    }
    



 
}
?>


