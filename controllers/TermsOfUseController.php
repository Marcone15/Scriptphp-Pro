<?php

namespace controller;

use models\TermsOfUse;

class TermsOfUseController {
    private $termsOfUseModel;

    public function __construct() {
        $this->termsOfUseModel = new TermsOfUse();
    }

    public function index() {
        $content = $this->termsOfUseModel->getContent();
        $this->render('termodeuso', ['content' => $content]);
    }

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }
}

?>
