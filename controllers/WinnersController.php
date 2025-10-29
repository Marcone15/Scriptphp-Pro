<?php

namespace controller;

use models\Campaign;

class WinnersController {
    private $campaignModel;

    public function __construct($pdo) {
        $this->campaignModel = new Campaign($pdo);
    }

    public function showWinners() {
        $winners = $this->campaignModel->getAllCampaigns();
        $this->render('ganhadores', ['winners' => $winners]);
    }

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }
}

?>
