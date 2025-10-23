<?php

namespace controller;

use models\Communication;

class CommunicationController {
    private $communicationModel;

    public function __construct($pdo) {
        $this->communicationModel = new Communication($pdo);
    }

    public function index() {
        $communications = $this->communicationModel->getAllCommunications();
        $this->render('comunicados', ['communications' => $communications]);
    }

    public function showDashboardCommunications() {
        $communications = $this->communicationModel->getAllCommunications();
        $this->renderDashboard('communications', ['communications' => $communications]);
    }

    public function addCommunication() {
        $communication = $_POST['communication'];
        $this->communicationModel->addCommunication($communication);
        header('Location: /dashboard/communications');
    }

    public function updateCommunication() {
        $id = $_POST['id'];
        $communication = $_POST['communication'];
        $this->communicationModel->updateCommunication($id, $communication);
        header('Location: /dashboard/communications');
    }

    public function deleteCommunication() {
        $id = $_POST['id'];
        $this->communicationModel->deleteCommunication($id);
        header('Location: /dashboard/communications');
    }

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }

    private function renderDashboard($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }
}
?>
