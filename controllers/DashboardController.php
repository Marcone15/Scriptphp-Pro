<?php

namespace controller;

use models\Campaign;
use models\User;
use models\Order;

class DashboardController {
    private $campaignModel;
    private $userModel;
    private $orderModel;

    public function __construct($pdo) {
        $this->campaignModel = new Campaign($pdo);
        $this->userModel = new User($pdo);
        $this->orderModel = new Order($pdo);
    }

    public function getDashboardData() {
        $totalCampaigns = $this->campaignModel->getTotalCampaigns();
        $totalUsers = $this->userModel->getTotalUsers() - 1;
        $totalOrders = $this->orderModel->getTotalOrders();
        $totalRevenue = $this->orderModel->getTotalRevenue();

        return [
            'totalCampaigns' => $totalCampaigns,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue
        ];
    }
}

?>
