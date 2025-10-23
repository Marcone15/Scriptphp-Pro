<?php

namespace controller;

use models\Ranking;

class RankingController {
    private $rankingModel;

    public function __construct($pdo) {
        $this->rankingModel = new Ranking($pdo);
    }

    public function showRanking() {
        $campaignId = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : null;
        $category = isset($_GET['category_ranking']) ? $_GET['category_ranking'] : 'Geral';

        $campaigns = $this->rankingModel->getCampaigns();
        $topBuyers = $this->rankingModel->getTopBuyers($campaignId, $category);

        $this->renderDashboard('ranking', [
            'campaigns' => $campaigns,
            'topBuyers' => $topBuyers,
            'category' => $category
        ]);
    }

    private function renderDashboard($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }
}
?>
