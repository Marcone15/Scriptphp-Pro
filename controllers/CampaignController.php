<?php
namespace controller;

use models\Campaign;
use PDO; 
use DateTime;
use DateTimeZone;

class CampaignController {
    private $campaignModel;

    public function __construct($pdo) {
        $this->campaignModel = new Campaign($pdo);
    }

    public function index() {
        $campaigns = $this->campaignModel->getAllCampaigns();
        $this->render('home', ['campaigns' => $campaigns]);
    }

    public function show($slug) {
        $campaign = $this->campaignModel->getCampaignBySlug($slug);
        if ($campaign) {
            $campaignId = $campaign['id'];
            $numbersSoldPercentage = $this->campaignModel->getNumbersSoldPercentage($campaignId);
            $topBuyers = $this->campaignModel->getTopBuyers($campaignId);
            $topBuyersToday = $this->campaignModel->getTopBuyers($campaignId, 3, true);
            $buyersOfDrawTitles = $this->campaignModel->getBuyersOfDrawTitles($campaignId);
    
            $pendingOrders = $soldOrders = [];
            $reservadosPagosLivres = $this->campaignModel->getReservadosPagosLivres($campaignId);
    
            if ($campaign['type_raffle'] === 'Normal' || $campaign['type_raffle'] === 'Fazendinha') {
                $pendingOrders = $this->campaignModel->getPendingOrders($campaignId);
                $soldOrders = $this->campaignModel->getSoldOrders($campaignId);
            }
    
            $this->render('single', [
                'campaign' => $campaign,
                'numbersSoldPercentage' => $numbersSoldPercentage,
                'topBuyers' => $topBuyers,
                'topBuyersToday' => $topBuyersToday,
                'buyersOfDrawTitles' => $buyersOfDrawTitles,
                'pendingOrders' => $pendingOrders,
                'soldOrders' => $soldOrders,
                'reservadosPagosLivres' => $reservadosPagosLivres
            ]);
        } else {
            header('Location: /');
            exit;
        }
    }
    
    

    public function listCampaigns() {
        $limit = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $totalCampaigns = $this->campaignModel->getCampaignCount();
        $campaigns = $this->campaignModel->getCampaignsByPage($limit, $offset);
    
        $this->render('campanhas', [
            'campaigns' => $campaigns,
            'totalCampaigns' => $totalCampaigns,
            'limit' => $limit,
            'currentPage' => $page
        ]);
    }

    public function getAllCampaigns($status = null) {
        $pdo = $this->campaignModel->getPdo();
    
        if ($status) {
            if ($status === 'Todas') {
                $stmt = $pdo->prepare('SELECT * FROM campaigns WHERE status IN (?, ?, ?) ORDER BY id DESC');
                $stmt->bindValue(1, 'Adquira já!', PDO::PARAM_STR);
                $stmt->bindValue(2, 'Corre que está acabando!', PDO::PARAM_STR);
                $stmt->bindValue(3, 'Concluído', PDO::PARAM_STR);
            } elseif ($status === 'Ativo') {
                $stmt = $pdo->prepare('SELECT * FROM campaigns WHERE status IN (?, ?) ORDER BY id DESC');
                $stmt->bindValue(1, 'Adquira já!', PDO::PARAM_STR);
                $stmt->bindValue(2, 'Corre que está acabando!', PDO::PARAM_STR);
            } else {
                $stmt = $pdo->prepare('SELECT * FROM campaigns WHERE status = ? ORDER BY id DESC');
                $stmt->bindValue(1, $status, PDO::PARAM_STR);
            }
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare('SELECT * FROM campaigns ORDER BY id DESC');
            $stmt->execute();
        }
    
        $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($campaigns as &$campaign) {
            $campaign['percentage_sold'] = $this->campaignModel->getNumbersSoldPercentage($campaign['id']);
        }
        return $campaigns;
    }

    public function deleteCampaign($id) {
        $pdo = $this->campaignModel->getPdo();
        
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare('SELECT numbers_file_path FROM campaigns WHERE id = ?');
            $stmt->execute([$id]);
            $filePath = $stmt->fetchColumn();
            
            $stmt = $pdo->prepare('DELETE FROM orders WHERE id_campaign = ?');
            $stmt->execute([$id]);
            
            $stmt = $pdo->prepare('DELETE FROM campaigns WHERE id = ?');
            $stmt->execute([$id]);
            
            $pdo->commit();
    
            if ($filePath && file_exists(__DIR__ . '/../campaigns/' . $filePath)) {
                unlink(__DIR__ . '/../campaigns/' . $filePath);
            }
    
        } catch (\PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
    
    
    public function searchWinner($campaignId, $titleNumber) {
        $pdo = $this->campaignModel->getPdo();
    
        ob_start();
    
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id_campaign = ?');
        $stmt->execute([$campaignId]);
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        foreach ($orders as $order) {
            $numbers = explode(', ', $order['numbers']);
            if (in_array($titleNumber, $numbers)) {
                $userStmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
                $userStmt->execute([$order['id_user']]);
                $user = $userStmt->fetch(\PDO::FETCH_ASSOC);
    
                $campaignStmt = $pdo->prepare('SELECT name, image_raffle FROM campaigns WHERE id = ?');
                $campaignStmt->execute([$campaignId]);
                $campaign = $campaignStmt->fetch(\PDO::FETCH_ASSOC);
    
                $updateStatusStmt = $pdo->prepare('UPDATE campaigns SET status = ? WHERE id = ?');
                $updateStatusStmt->execute(['Concluído', $campaignId]);
    
                $now = new \DateTime();
                $now->modify('-4 hours');
                $formattedDate = $now->format('d/m/y \à\s H:i');
    
                $winnerDetails = ($order['image_user'] ?? 'default.jpg') . ', ' . $user['name'] . ', ' . $titleNumber . ', ' . $formattedDate;
                $updateWinnerStmt = $pdo->prepare('UPDATE campaigns SET winner = ? WHERE id = ?');
                $updateWinnerStmt->execute([$winnerDetails, $campaignId]);
    
                ob_clean();
                
                header('Content-Type: text/plain');
    
                echo "success\n";
                echo "number: $titleNumber\n";
                echo "buyer: {$user['name']}\n";
                echo "date: {$order['created_at']}\n";
                echo "campaign_name: {$campaign['name']}\n";
                echo "phone: {$user['phone']}\n";
                echo "cpf: {$user['cpf']}\n";
                echo "image: " . ($order['image_user'] ?? 'default.jpg') . "\n";
                echo "image_raffle: {$campaign['image_raffle']}\n";
                echo "order_code: {$order['hash_order']}\n";
                ob_end_flush();
                return;
            }
        }
    
        ob_clean();
    
        header('Content-Type: text/plain');
    
        echo "fail";
        ob_end_flush();
    }


    public function editCampaign($id) {
        $pdo = $this->campaignModel->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM campaigns WHERE id = ?');
        $stmt->execute([$id]);
        $campaign = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$campaign) {
            header('Location: /dashboard/campaigns');
            exit;
        }

        include __DIR__ . '/../views/dashboard/editcampaign.php';
    }

    public function createCampaign() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeRaffle = $_POST['type_raffle'];
            $name = $_POST['name'];
            $subname = $_POST['subname'];
            $description = $_POST['description'];
            $price = number_format(floatval(str_replace(',', '.', $_POST['price'])), 2, ',', '');
            $progressBar = isset($_POST['progress_bar']) ? 1 : 0;
            $favorite = isset($_POST['favorite']) ? 1 : 0;
            $ranking = isset($_POST['ranking']) ? 1 : 0;
            $rankingDiary = isset($_POST['ranking_diary']) ? 1 : 0;
            $biggerSmallerTitle = isset($_POST['bigger_smaller_title']) ? 1 : 0;
            $biggerSmallerTitleDiary = isset($_POST['bigger_smaller_title_diary']) ? 1 : 0;
            $status = $_POST['status'];
            $expirationPix = $_POST['expiration_pix'];
            $qtdNumbers = $_POST['qtd_numbers'];
            $qtdMin = $_POST['qtd_min'];
            $qtdMax = $_POST['qtd_max'];
            $drawDate = $_POST['draw_date'] ?: null;
            $qtdSelect = $_POST['qtd_select'] ?: '0';
            $drawTitles = $_POST['draw_titles'] ?: '0';
            $awardTitles = $_POST['award_titles'] ?: '0';
            $rankingPhrase = $_POST['ranking_phrase'] ?: null;
            $rankingDiaryPhrase = $_POST['ranking_diary_phrase'] ?: null;
            
            $timezone = new DateTimeZone('America/Sao_Paulo');
            $now = new DateTime('now', $timezone);
            $createdAt = $now->format('Y-m-d H:i:s');
            $updatedAt = $now->format('Y-m-d H:i:s');
    
            $imageRaffle = 'no-image.png';
            if (isset($_FILES['image_raffle']) && $_FILES['image_raffle']['error'] == 0) {
                $imageRaffle = $this->processImage($_FILES['image_raffle']);
            }
    
            $imageRaffleGalery = null;
            if (isset($_FILES['image_raffle_galery'])) {
                $imageRaffleGalery = $this->processGallery($_FILES['image_raffle_galery']);
            }
    
            $slug = $this->generateSlug($name);
    
            $qtdPromo1 = !empty($_POST['qtd_promo_1']) ? $_POST['qtd_promo_1'] : '';
            $qtdPromo2 = !empty($_POST['qtd_promo_2']) ? $_POST['qtd_promo_2'] : '';
            $qtdPromo3 = !empty($_POST['qtd_promo_3']) ? $_POST['qtd_promo_3'] : '';
            $qtdPromo = implode(', ', array_filter([$qtdPromo1, $qtdPromo2, $qtdPromo3]));
    
            $pricePromo1 = !empty($_POST['price_promo_1']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_1'])), 2, ',', '') : '';
            $pricePromo2 = !empty($_POST['price_promo_2']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_2'])), 2, ',', '') : '';
            $pricePromo3 = !empty($_POST['price_promo_3']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_3'])), 2, ',', '') : '';
            $pricePromo = implode(', ', array_filter([$pricePromo1, $pricePromo2, $pricePromo3]));
    
            $fileName = null;
    
            if ($typeRaffle === 'Automática') {
                $numDigits = strlen($qtdNumbers) - 1;
                $fileName = 'campaign_' . $slug . '_' . time() . '.txt';
                $filePath = __DIR__ . '/../campaigns/' . $fileName;
    
                $numbers = range(0, $qtdNumbers - 1);
                shuffle($numbers);
    
                $fileHandle = fopen($filePath, 'w');
                if ($fileHandle) {
                    $chunkSize = 100000;
                    $buffer = [];
                    foreach ($numbers as $number) {
                        $buffer[] = str_pad($number, $numDigits, '0', STR_PAD_LEFT);
                        if (count($buffer) >= $chunkSize) {
                            fwrite($fileHandle, implode(', ', $buffer) . ', ');
                            $buffer = [];
                        }
                    }
    
                    if (!empty($buffer)) {
                        fwrite($fileHandle, implode(', ', $buffer));
                    }
    
                    fclose($fileHandle);
                } else {
                    throw new Exception("Não foi possível abrir o arquivo para escrita.");
                }
            }
    
            $this->campaignModel->createCampaign([
                'type_raffle' => $typeRaffle,
                'name' => $name,
                'subname' => $subname,
                'image_raffle' => $imageRaffle,
                'image_raffle_galery' => $imageRaffleGalery,
                'price' => $price,
                'progress_bar' => $progressBar,
                'favorite' => $favorite,
                'ranking' => $ranking,
                'ranking_diary' => $rankingDiary,
                'bigger_smaller_title' => $biggerSmallerTitle,
                'bigger_smaller_title_diary' => $biggerSmallerTitleDiary,
                'description' => $description,
                'slug' => $slug,
                'status' => $status,
                'expiration_pix' => $expirationPix,
                'qtd_numbers' => $qtdNumbers,
                'qtd_min' => $qtdMin,
                'qtd_max' => $qtdMax,
                'draw_date' => $drawDate,
                'qtd_select' => $qtdSelect,
                'draw_titles' => $drawTitles,
                'award_titles' => $awardTitles,
                'qtd_promo' => $qtdPromo,
                'price_promo' => $pricePromo,
                'ranking_phrase' => $rankingPhrase,
                'ranking_diary_phrase' => $rankingDiaryPhrase,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'numbers_file_path' => $fileName 
            ]);
    
            header('Location: /dashboard/campaigns');
            exit();
        }
    }
    
    


    
    private function processImage($image) {
        $imageName = uniqid() . '-' . basename($image['name']);
        $targetFilePath = __DIR__ . '/../public/images/' . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
            return $imageName;
        }

        return 'no-image.png';
    }

    private function processGallery($images) {
        $imageNames = [];
    
        if (is_array($images['tmp_name'])) {
            foreach ($images['tmp_name'] as $index => $tmpName) {
                if (!empty($tmpName) && $images['error'][$index] == 0) {
                    $imageName = uniqid() . '-' . basename($images['name'][$index]);
                    $targetFilePath = __DIR__ . '/../public/images/' . $imageName;
    
                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $imageNames[] = $imageName;
                    }
                }
            }
        }
    
        return implode(', ', $imageNames);
    }
    
    

    private function generateSlug($name) {
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $name));

        $existingSlug = $this->campaignModel->getSlug($slug);
        if ($existingSlug) {
            $slug .= '-' . uniqid();
        }

        return $slug;
    }

    private function processPromotions($fields, $isPrice = false) {
        $values = [];
    
        foreach ($fields as $field) {
            if ($isPrice) {
                $values[] = isset($_POST[$field]) && !empty($_POST[$field]) ? number_format(floatval(str_replace(',', '.', $_POST[$field])), 2, ',', '') : '';
            } else {
                $values[] = isset($_POST[$field]) && !empty($_POST[$field]) ? $_POST[$field] : '';
            }
        }
    
        return implode(', ', $values);
    }
    
    public function updateCampaign($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeRaffle = $_POST['type_raffle'];
            $name = $_POST['name'];
            $subname = $_POST['subname'];
            $description = $_POST['description'];
            $price = number_format(floatval(str_replace(',', '.', $_POST['price'])), 2, ',', '');
            $progressBar = isset($_POST['progress_bar']) ? 1 : 0;
            $favorite = isset($_POST['favorite']) ? 1 : 0;
            $ranking = isset($_POST['ranking']) ? 1 : 0;
            $rankingDiary = isset($_POST['ranking_diary']) ? 1 : 0;
            $biggerSmallerTitle = isset($_POST['bigger_smaller_title']) ? 1 : 0;
            $biggerSmallerTitleDiary = isset($_POST['bigger_smaller_title_diary']) ? 1 : 0;
            $status = $_POST['status'];
            $expirationPix = $_POST['expiration_pix'];
            $qtdNumbers = $_POST['qtd_numbers'];
            $qtdMin = $_POST['qtd_min'];
            $qtdMax = $_POST['qtd_max'];
            $drawDate = $_POST['draw_date'] ?: null;
            $qtdSelect = $_POST['qtd_select'] ?: '0';
            $drawTitles = $_POST['draw_titles'] ?: '0';
            $awardTitles = $_POST['award_titles'] ?: '0';
            $rankingPhrase = $_POST['ranking_phrase'] ?: null;
            $rankingDiaryPhrase = $_POST['ranking_diary_phrase'] ?: null;
            $createdAt = $_POST['created_at'];
            $updatedAt = date('Y-m-d H:i:s', strtotime('-4 hours'));
            $slug = $_POST['slug'];
    
            $imageRaffle = $_POST['image_raffle_old'];
            if (isset($_FILES['image_raffle']) && $_FILES['image_raffle']['error'] == 0) {
                $imageRaffle = $this->processImage($_FILES['image_raffle']);
            }
    
            $imageRaffleGalery = $_POST['image_raffle_galery_old'];
            if (isset($_FILES['image_raffle_galery']) && $_FILES['image_raffle_galery']['error'][0] == 0) {
                $imageRaffleGalery = $this->processGallery($_FILES['image_raffle_galery']);
            }
    
            $qtdPromo1 = !empty($_POST['qtd_promo_1']) ? $_POST['qtd_promo_1'] : '';
            $qtdPromo2 = !empty($_POST['qtd_promo_2']) ? $_POST['qtd_promo_2'] : '';
            $qtdPromo3 = !empty($_POST['qtd_promo_3']) ? $_POST['qtd_promo_3'] : '';
            $qtdPromo = implode(', ', array_filter([$qtdPromo1, $qtdPromo2, $qtdPromo3]));
            
            $pricePromo1 = !empty($_POST['price_promo_1']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_1'])), 2, ',', '') : '';
            $pricePromo2 = !empty($_POST['price_promo_2']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_2'])), 2, ',', '') : '';
            $pricePromo3 = !empty($_POST['price_promo_3']) ? number_format(floatval(str_replace(',', '.', $_POST['price_promo_3'])), 2, ',', '') : '';
            $pricePromo = implode(', ', array_filter([$pricePromo1, $pricePromo2, $pricePromo3]));
    
            $this->campaignModel->updateCampaign($id, [
                'type_raffle' => $typeRaffle,
                'name' => $name,
                'subname' => $subname,
                'image_raffle' => $imageRaffle,
                'image_raffle_galery' => $imageRaffleGalery,
                'price' => $price,
                'progress_bar' => $progressBar,
                'favorite' => $favorite,
                'ranking' => $ranking,
                'ranking_diary' => $rankingDiary,
                'bigger_smaller_title' => $biggerSmallerTitle,
                'bigger_smaller_title_diary' => $biggerSmallerTitleDiary,
                'description' => $description,
                'slug' => $slug,
                'status' => $status,
                'expiration_pix' => $expirationPix,
                'qtd_numbers' => $qtdNumbers,
                'qtd_min' => $qtdMin,
                'qtd_max' => $qtdMax,
                'draw_date' => $drawDate,
                'qtd_select' => $qtdSelect,
                'draw_titles' => $drawTitles,
                'award_titles' => $awardTitles,
                'qtd_promo' => $qtdPromo,
                'price_promo' => $pricePromo,
                'ranking_phrase' => $rankingPhrase,
                'ranking_diary_phrase' => $rankingDiaryPhrase,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
    
            header('Location: /dashboard/campaigns');
            exit();
        }
    }
    
    

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }

    
}
?>