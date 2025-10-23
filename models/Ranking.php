<?php

namespace models;

use PDO;

class Ranking {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCampaigns() {
        $stmt = $this->pdo->query('SELECT id, name FROM campaigns');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopBuyers($campaignId, $category) {
        $dateCondition = '';
        $params = [$campaignId];

        if ($category === 'Diário') {
            $dateCondition = ' AND DATE(created_at) = CURDATE()';
        }

        $query = '
            SELECT id_user, SUM(quantity) AS total_quantity
            FROM orders
            WHERE id_campaign = ? AND payment_status = "pago" ' . $dateCondition . '
            GROUP BY id_user
            ORDER BY total_quantity DESC
            LIMIT 3';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $topBuyers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $buyersData = [];
        foreach ($topBuyers as $buyer) {
            $query = '
                SELECT u.name, u.phone, u.image_user, o.total_quantity
                FROM users u
                JOIN (
                    SELECT id_user, SUM(quantity) AS total_quantity
                    FROM orders
                    WHERE id_user = ? AND id_campaign = ? AND payment_status = "pago" ' . $dateCondition . '
                    GROUP BY id_user
                ) o ON u.id = o.id_user
                LIMIT 1';

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$buyer['id_user'], $campaignId]);
            $buyerData = $stmt->fetch(PDO::FETCH_ASSOC);
            $buyersData[] = $buyerData;
        }

        return $buyersData;
    }
}
?>
