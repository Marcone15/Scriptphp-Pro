<?php

namespace models;

use PDO; 

class Campaign {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function getCampaignBySlug($slug) {
        $stmt = $this->pdo->prepare('SELECT * FROM campaigns WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllCampaigns() {
        $stmt = $this->pdo->query('SELECT * FROM campaigns ORDER BY id DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPendingOrders($campaignId) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id_campaign = ? AND payment_status = "pendente"');
        $stmt->execute([$campaignId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSoldOrders($campaignId) {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id_campaign = ? AND payment_status = "pago"');
        $stmt->execute([$campaignId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getNumbersSoldPercentage($campaignId) {
        $stmt = $this->pdo->prepare('SELECT SUM(quantity) AS total_sold FROM orders WHERE id_campaign = ? AND payment_status = "pago"');
        $stmt->execute([$campaignId]);
        $numbersSold = $stmt->fetchColumn();
    
        $stmt = $this->pdo->prepare('SELECT qtd_numbers FROM campaigns WHERE id = ?');
        $stmt->execute([$campaignId]);
        $totalNumbers = $stmt->fetchColumn();
    
        return ($numbersSold / $totalNumbers) * 100;
    }

    public function getTopBuyers($campaignId, $limit = 3, $todayOnly = false) {
        $dateCondition = $todayOnly ? 'AND DATE(orders.created_at) = CURDATE()' : '';
        $stmt = $this->pdo->prepare(
            "SELECT users.name, SUM(orders.quantity) as total_numbers 
            FROM orders 
            JOIN users ON orders.id_user = users.id 
            WHERE orders.id_campaign = ? AND orders.payment_status = 'pago' $dateCondition 
            GROUP BY users.id 
            ORDER BY total_numbers DESC 
            LIMIT ?"
        );
        $stmt->bindValue(1, $campaignId, \PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCampaignQuantityDigits($campaignId) {
        $stmt = $this->pdo->prepare("SELECT qtd_numbers FROM campaigns WHERE id = ?");
        $stmt->execute([$campaignId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? strlen($result['qtd_numbers']) - 1 : 0;
    }

    public function getMinMaxNumbers($campaignId) {
        $quantityDigits = $this->getCampaignQuantityDigits($campaignId);
    
        $stmt = $this->pdo->prepare('
            SELECT users.name, orders.numbers, orders.created_at 
            FROM orders 
            JOIN users ON orders.id_user = users.id 
            WHERE orders.id_campaign = ? AND orders.payment_status = "pago"');
        $stmt->execute([$campaignId]);
    
        $minNumber = PHP_INT_MAX;
        $maxNumber = PHP_INT_MIN;
        $minRecord = null;
        $maxRecord = null;
    
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $numbers = explode(', ', $row['numbers']);
            foreach ($numbers as $number) {
                $trimmedNumber = ltrim($number, '0');
                $trimmedNumber = $trimmedNumber === '' ? '0' : $trimmedNumber;
                $numberValue = intval($trimmedNumber);
    
                if ($numberValue < $minNumber) {
                    $minNumber = $numberValue;
                    $minRecord = ['number' => $numberValue, 'user' => $row['name'], 'date' => $row['created_at']];
                }
    
                if ($numberValue > $maxNumber) {
                    $maxNumber = $numberValue;
                    $maxRecord = ['number' => $numberValue, 'user' => $row['name'], 'date' => $row['created_at']];
                }
            }
        }
    
        if ($minRecord === null || $maxRecord === null) {
            return [
                'min' => null,
                'max' => null
            ];
        }
    
        $minNumber = str_pad($minNumber, $quantityDigits, '0', STR_PAD_LEFT);
        $maxNumber = str_pad($maxNumber, $quantityDigits, '0', STR_PAD_LEFT);
    
        return [
            'min' => ['number' => $minNumber, 'user' => $minRecord['user'], 'date' => $minRecord['date']],
            'max' => ['number' => $maxNumber, 'user' => $maxRecord['user'], 'date' => $maxRecord['date']]
        ];
    }
    
    
    public function getMinMaxNumbersToday($campaignId) {
        $quantityDigits = $this->getCampaignQuantityDigits($campaignId);
    
        $stmt = $this->pdo->prepare('
            SELECT users.name, orders.numbers, orders.created_at 
            FROM orders 
            JOIN users ON orders.id_user = users.id 
            WHERE orders.id_campaign = ? AND orders.payment_status = "pago" AND DATE(orders.created_at) = CURDATE()');
        $stmt->execute([$campaignId]);
    
        $minNumber = PHP_INT_MAX;
        $maxNumber = PHP_INT_MIN;
        $minRecord = null;
        $maxRecord = null;
    
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $numbers = explode(', ', $row['numbers']);
            foreach ($numbers as $number) {
                $trimmedNumber = ltrim($number, '0');
                $trimmedNumber = $trimmedNumber === '' ? '0' : $trimmedNumber; 
                $numberValue = intval($trimmedNumber);
    
                if ($numberValue < $minNumber) {
                    $minNumber = $numberValue;
                    $minRecord = ['number' => $numberValue, 'user' => $row['name'], 'date' => $row['created_at']];
                }
    
                if ($numberValue > $maxNumber) {
                    $maxNumber = $numberValue;
                    $maxRecord = ['number' => $numberValue, 'user' => $row['name'], 'date' => $row['created_at']];
                }
            }
        }
    
        if ($minRecord === null || $maxRecord === null) {
            return [
                'min' => null,
                'max' => null
            ];
        }
    
        $minNumber = str_pad($minNumber, $quantityDigits, '0', STR_PAD_LEFT);
        $maxNumber = str_pad($maxNumber, $quantityDigits, '0', STR_PAD_LEFT);
    
        return [
            'min' => ['number' => $minNumber, 'user' => $minRecord['user'], 'date' => $minRecord['date']],
            'max' => ['number' => $maxNumber, 'user' => $maxRecord['user'], 'date' => $maxRecord['date']]
        ];
    }
    
    
    public function updateMinMaxTitles($campaignId) {
        $minMaxGeneral = $this->getMinMaxNumbers($campaignId); 
        $minMaxDaily = $this->getMinMaxNumbersToday($campaignId); 
    
        $minGeneralDetails = $minMaxGeneral['min']['number'] . ', ' . $minMaxGeneral['min']['user'] . ', ' . $minMaxGeneral['min']['date'];
        $maxGeneralDetails = $minMaxGeneral['max']['number'] . ', ' . $minMaxGeneral['max']['user'] . ', ' . $minMaxGeneral['max']['date'];
    
        $minDailyDetails = $minMaxDaily['min']['number'] . ', ' . $minMaxDaily['min']['user'] . ', ' . $minMaxDaily['min']['date'];
        $maxDailyDetails = $minMaxDaily['max']['number'] . ', ' . $minMaxDaily['max']['user'] . ', ' . $minMaxDaily['max']['date'];
    
        $stmt = $this->pdo->prepare('
            UPDATE campaigns 
            SET min_title_general = ?, max_title_general = ?, min_title_daily = ?, max_title_daily = ? 
            WHERE id = ?');
        $stmt->execute([
            $minGeneralDetails,
            $maxGeneralDetails,
            $minDailyDetails,
            $maxDailyDetails,
            $campaignId
        ]);
    }
    
    
    public function getBuyersOfDrawTitles($campaignId) {
        $stmt = $this->pdo->prepare('SELECT draw_titles FROM campaigns WHERE id = ?');
        $stmt->execute([$campaignId]);
        $drawTitlesArray = explode(', ', $stmt->fetchColumn());
    
        $drawTitlesSet = array_flip($drawTitlesArray);
    
        $sql = '
            SELECT users.name, orders.numbers 
            FROM orders 
            JOIN users ON orders.id_user = users.id 
            WHERE orders.id_campaign = ? AND orders.payment_status = "pago"
        ';
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$campaignId]);
        
        $buyers = [];
    
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $numbers = explode(', ', $row['numbers']);
            foreach ($numbers as $number) {
                if (isset($drawTitlesSet[$number])) {
                    $buyers[$number] = $row['name'];
                }
            }
        }
        
        return $buyers;
    }

    public function getReservadosPagosLivres($campaignId) {
        $stmt = $this->pdo->prepare('SELECT SUM(quantity) as total_reserved FROM orders WHERE id_campaign = ? AND payment_status = "pendente"');
        $stmt->execute([$campaignId]);
        $totalReserved = $stmt->fetchColumn();
    
        $stmt = $this->pdo->prepare('SELECT SUM(quantity) as total_paid FROM orders WHERE id_campaign = ? AND payment_status = "pago"');
        $stmt->execute([$campaignId]);
        $totalPaid = $stmt->fetchColumn();
    
        $stmt = $this->pdo->prepare('SELECT qtd_numbers FROM campaigns WHERE id = ?');
        $stmt->execute([$campaignId]);
        $totalNumbers = $stmt->fetchColumn();
        $totalFree = $totalNumbers - ($totalReserved + $totalPaid);
    
        return [
            'reservados' => $totalReserved,
            'pagos' => $totalPaid,
            'livres' => $totalFree
        ];
    }

    public function getNumbersStatus($campaignId) {
        $stmt = $this->pdo->prepare('SELECT numbers, payment_status FROM orders WHERE id_campaign = ?');
        $stmt->execute([$campaignId]);
        $numbersStatus = [];
    
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $numbers = explode(', ', $row['numbers']);
            foreach ($numbers as $number) {
                $numbersStatus[$number] = $row['payment_status'];
            }
        }
    
        return $numbersStatus;
    }

    public function getCampaignById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM campaigns WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getCampaignCount() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM campaigns');
        return $stmt->fetchColumn();
    }
    
    public function getCampaignsByPage($limit, $offset) {
        $stmt = $this->pdo->prepare('SELECT * FROM campaigns ORDER BY id DESC LIMIT ? OFFSET ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTotalCampaigns() {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM campaigns');
        return $stmt->fetchColumn();
    }

    public function getActiveCampaigns() {
        $stmt = $this->pdo->prepare('SELECT * FROM campaigns WHERE status IN ("Adquira já!", "Corre que está acabando!")');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSlug($slug) {
        $query = $this->pdo->prepare("SELECT * FROM campaigns WHERE slug = :slug");
        $query->execute(['slug' => $slug]);
        return $query->fetch();
    }

    public function createCampaign($data) {
        $query = "INSERT INTO campaigns (type_raffle, name, subname, image_raffle, image_raffle_galery, price, progress_bar, favorite, ranking, ranking_diary, bigger_smaller_title, bigger_smaller_title_diary, description, slug, status, expiration_pix, qtd_numbers, qtd_min, qtd_max, draw_date, qtd_select, draw_titles, award_titles, qtd_promo, price_promo, ranking_phrase, ranking_diary_phrase, created_at, updated_at, numbers_file_path) 
                  VALUES (:type_raffle, :name, :subname, :image_raffle, :image_raffle_galery, :price, :progress_bar, :favorite, :ranking, :ranking_diary, :bigger_smaller_title, :bigger_smaller_title_diary, :description, :slug, :status, :expiration_pix, :qtd_numbers, :qtd_min, :qtd_max, :draw_date, :qtd_select, :draw_titles, :award_titles, :qtd_promo, :price_promo, :ranking_phrase, :ranking_diary_phrase, :created_at, :updated_at, :numbers_file_path)";
        
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }
    
    

    public function updateCampaign($id, $data) {
        $sql = "UPDATE campaigns SET
            type_raffle = :type_raffle,
            name = :name,
            subname = :subname,
            image_raffle = :image_raffle,
            image_raffle_galery = :image_raffle_galery,
            price = :price,
            progress_bar = :progress_bar,
            favorite = :favorite,
            ranking = :ranking,
            ranking_diary = :ranking_diary,
            bigger_smaller_title = :bigger_smaller_title,
            bigger_smaller_title_diary = :bigger_smaller_title_diary,
            description = :description,
            slug = :slug,
            status = :status,
            expiration_pix = :expiration_pix,
            qtd_numbers = :qtd_numbers,
            qtd_min = :qtd_min,
            qtd_max = :qtd_max,
            draw_date = :draw_date,
            qtd_select = :qtd_select,
            draw_titles = :draw_titles,
            award_titles = :award_titles,
            qtd_promo = :qtd_promo,
            price_promo = :price_promo,
            ranking_phrase = :ranking_phrase,
            ranking_diary_phrase = :ranking_diary_phrase,
            created_at = :created_at,
            updated_at = :updated_at
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':type_raffle', $data['type_raffle'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':subname', $data['subname'], \PDO::PARAM_STR);
        $stmt->bindParam(':image_raffle', $data['image_raffle'], \PDO::PARAM_STR);
        $stmt->bindParam(':image_raffle_galery', $data['image_raffle_galery'], \PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], \PDO::PARAM_STR);
        $stmt->bindParam(':progress_bar', $data['progress_bar'], \PDO::PARAM_INT);
        $stmt->bindParam(':favorite', $data['favorite'], \PDO::PARAM_INT);
        $stmt->bindParam(':ranking', $data['ranking'], \PDO::PARAM_INT);
        $stmt->bindParam(':ranking_diary', $data['ranking_diary'], \PDO::PARAM_INT);
        $stmt->bindParam(':bigger_smaller_title', $data['bigger_smaller_title'], \PDO::PARAM_INT);
        $stmt->bindParam(':bigger_smaller_title_diary', $data['bigger_smaller_title_diary'], \PDO::PARAM_INT);
        $stmt->bindParam(':description', $data['description'], \PDO::PARAM_STR);
        $stmt->bindParam(':slug', $data['slug'], \PDO::PARAM_STR);
        $stmt->bindParam(':status', $data['status'], \PDO::PARAM_STR);
        $stmt->bindParam(':expiration_pix', $data['expiration_pix'], \PDO::PARAM_INT);
        $stmt->bindParam(':qtd_numbers', $data['qtd_numbers'], \PDO::PARAM_INT);
        $stmt->bindParam(':qtd_min', $data['qtd_min'], \PDO::PARAM_INT);
        $stmt->bindParam(':qtd_max', $data['qtd_max'], \PDO::PARAM_INT);
        $stmt->bindParam(':draw_date', $data['draw_date'], \PDO::PARAM_STR);
        $stmt->bindParam(':qtd_select', $data['qtd_select'], \PDO::PARAM_STR);
        $stmt->bindParam(':draw_titles', $data['draw_titles'], \PDO::PARAM_STR);
        $stmt->bindParam(':award_titles', $data['award_titles'], \PDO::PARAM_STR);
        $stmt->bindParam(':qtd_promo', $data['qtd_promo'], \PDO::PARAM_STR);
        $stmt->bindParam(':price_promo', $data['price_promo'], \PDO::PARAM_STR);
        $stmt->bindParam(':ranking_phrase', $data['ranking_phrase'], \PDO::PARAM_STR);
        $stmt->bindParam(':ranking_diary_phrase', $data['ranking_diary_phrase'], \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $data['created_at'], \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $data['updated_at'], \PDO::PARAM_STR);

        $stmt->execute();
    }

}
?>



    

