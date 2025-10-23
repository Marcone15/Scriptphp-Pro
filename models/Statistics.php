<?php

namespace models;

use PDO;

class Statistics {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getCampaigns() {
        $stmt = $this->pdo->query('SELECT id, name FROM campaigns');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParticipantsCount($campaignId = null) {
        $query = 'SELECT COUNT(DISTINCT id_user) AS participants FROM orders WHERE payment_status = "pago"';
        $params = [];
        
        if ($campaignId) {
            $query .= ' AND id_campaign = ?';
            $params[] = $campaignId;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['participants'];
    }

    public function getOrdersCount($campaignId = null) {
        $query = 'SELECT COUNT(*) AS orders FROM orders WHERE payment_status = "pago"';
        $params = [];
        
        if ($campaignId) {
            $query .= ' AND id_campaign = ?';
            $params[] = $campaignId;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['orders'];
    }

    public function getTitlesSold($campaignId = null) {
        $query = 'SELECT SUM(quantity) AS titles_sold FROM orders WHERE payment_status = "pago"';
        $params = [];
        
        if ($campaignId) {
            $query .= ' AND id_campaign = ?';
            $params[] = $campaignId;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['titles_sold'];
    }

    public function getTotalRevenue($campaignId = null) {
        $query = 'SELECT SUM(REPLACE(total, ",", ".") * 1) AS total_revenue FROM orders WHERE payment_status = "pago"';
        $params = [];
        
        if ($campaignId) {
            $query .= ' AND id_campaign = ?';
            $params[] = $campaignId;
        }
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
    }

    public function getDailyStatistics($campaignId = null) {
        $query = '
            SELECT 
                DATE(created_at) AS date, 
                COUNT(DISTINCT id_user) AS participants, 
                COUNT(*) AS orders, 
                SUM(quantity) AS titles_sold, 
                SUM(REPLACE(total, ",", ".") * 1) AS total_revenue 
            FROM orders 
            WHERE payment_status = "pago"';
        
        $params = [];
        
        if ($campaignId) {
            $query .= ' AND id_campaign = ?';
            $params[] = $campaignId;
        }
        
        $query .= ' GROUP BY DATE(created_at) HAVING COUNT(*) > 0 ORDER BY date DESC';
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>