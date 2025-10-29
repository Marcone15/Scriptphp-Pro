<?php

namespace controller;

use models\Statistics;

class StatisticsController {
    private $statisticsModel;

    public function __construct($pdo) {
        $this->statisticsModel = new Statistics($pdo);
    }

    public function showStatistics() {
        $campaignId = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : null;
        
        $campaigns = $this->statisticsModel->getCampaigns();
        $participants = $this->statisticsModel->getParticipantsCount($campaignId);
        $orders = $this->statisticsModel->getOrdersCount($campaignId);
        $titlesSold = $this->statisticsModel->getTitlesSold($campaignId);
        $totalRevenue = $this->statisticsModel->getTotalRevenue($campaignId);
        $dailyStatistics = $this->statisticsModel->getDailyStatistics($campaignId);

        $this->renderDashboard('statistics', [
            'campaigns' => $campaigns,
            'participants' => $participants,
            'orders' => $orders,
            'titlesSold' => $titlesSold,
            'totalRevenue' => $totalRevenue,
            'dailyStatistics' => $dailyStatistics
        ]);
    }

    private function renderDashboard($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }
}


?>