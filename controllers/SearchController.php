<?php

namespace controller;

use models\Campaign;
use models\Order;
use models\User;
use DateTime;
use DateTimeZone;

class SearchController {
    private $campaignModel;
    private $orderModel;
    private $userModel;

    public function __construct($pdo) {
        $this->campaignModel = new Campaign($pdo);
        $this->orderModel = new Order($pdo);
        $this->userModel = new User($pdo);
    }

    public function search() {
        $viewData = [
            'campaigns' => $this->campaignModel->getActiveCampaigns(),
            'result' => null
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['search_title'])) {
                $viewData['result'] = $this->searchTitle($_GET['campaign_id'], $_GET['title']);
            } elseif (isset($_GET['search_title_award'])) {
                $viewData['result'] = $this->searchTitleAward($_GET['campaign_id']);
            } elseif (isset($_GET['search_bigger_smaller_title'])) {
                $viewData['result'] = $this->searchBiggerSmallerTitle($_GET['campaign_id'], $_GET['type']);
            }
        }

        $this->render('search', $viewData);
    }

    private function searchTitle($campaignId, $title) {
        $orders = $this->orderModel->getOrdersByCampaignAndStatus($campaignId, 'pago');
        foreach ($orders as $order) {
            $numbers = explode(',', $order['numbers']);
            if (in_array($title, $numbers)) {
                $user = $this->userModel->getUserById($order['id_user']);
                return [
                    'title' => $title,
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'cpf' => $user['cpf'],
                    'campaign' => $this->campaignModel->getCampaignById($campaignId)['name'],
                    'hash_order' => $order['hash_order'],
                    'created_at' => $order['created_at']
                ];
            }
        }
        return 'Título não encontrado';
    }

    private function searchTitleAward($campaignId) {
        $campaign = $this->campaignModel->getCampaignById($campaignId);
        $drawTitles = explode(',', $campaign['draw_titles']);
        $orders = $this->orderModel->getOrdersByCampaignAndStatus($campaignId, 'pago');
    
        $results = [];
    
        foreach ($orders as $order) {
            $numbers = explode(',', $order['numbers']);
            foreach ($numbers as $number) {
                if (in_array($number, $drawTitles)) {
                    $user = $this->userModel->getUserById($order['id_user']);
                    $results[] = [
                        'title' => $number,
                        'name' => $user['name'],
                        'phone' => $user['phone'],
                        'cpf' => $user['cpf'],
                        'campaign' => $campaign['name'],
                        'hash_order' => $order['hash_order'],
                        'created_at' => $order['created_at']
                    ];
                }
            }
        }
        return empty($results) ? 'Nenhum título premiado encontrado' : $results;
    }
    

    private function searchBiggerSmallerTitle($campaignId, $type) {
        date_default_timezone_set('America/Sao_Paulo');
    
        $campaign = $this->campaignModel->getCampaignById($campaignId);
    
        if ($type === 'Diário') {
            $minTitles = explode(', ', $campaign['min_title_daily']);
            $maxTitles = explode(', ', $campaign['max_title_daily']);
        } else {
            $minTitles = explode(', ', $campaign['min_title_general']);
            $maxTitles = explode(', ', $campaign['max_title_general']);
        }
    
        $processTitles = function($titles) use ($campaignId, $type) {
            $titleNumber = $titles[0];
            $order = $this->orderModel->getOrderByNumber($campaignId, $titleNumber);
            $user = $this->userModel->getUserById($order['id_user']);
            $formattedDate = (new DateTime($order['created_at']))->format('d/m/y \à\s H:i');
    
            $purchaseDate = (new DateTime($order['created_at']))->format('Y-m-d');
            $todayDate = (new DateTime())->format('Y-m-d');
            if ($type === 'Diário' && $purchaseDate !== $todayDate) {
                return null; 
            }
    
            return [
                'Título' => $titleNumber,
                'Comprador(a)' => $titles[1],
                'Telefone' => $user['phone'],
                'CPF' => $user['cpf'],
                'Campanha' => $this->campaignModel->getCampaignById($campaignId)['name'],
                'ID do pedido' => $order['hash_order'],
                'Data da compra' => $formattedDate
            ];
        };
    
        $minTitle = $processTitles($minTitles);
        $maxTitle = $processTitles($maxTitles);
    
        return array_filter([
            'Menor título' => $minTitle,
            'Maior título' => $maxTitle
        ]);
    }
    

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }
}
?>
