<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

require __DIR__ . '/config/config.php';
require __DIR__ . '/models/Settings.php';
require __DIR__ . '/controllers/SettingsController.php';

use controller\SettingsController;

$settingsController = new SettingsController($pdo);
$settings = $settingsController->getSettings();

session_start();

require __DIR__ . '/controllers/CampaignController.php';
require __DIR__ . '/models/Campaign.php';
require __DIR__ . '/controllers/PurchaseController.php';
require __DIR__ . '/models/Order.php';
require __DIR__ . '/models/User.php';
require __DIR__ . '/controllers/UserController.php';
require __DIR__ . '/controllers/CommunicationController.php';
require __DIR__ . '/models/Communication.php';
require __DIR__ . '/controllers/TermsOfUseController.php';
require __DIR__ . '/models/TermsOfUse.php';
require __DIR__ . '/controllers/OrdersController.php';
require __DIR__ . '/controllers/RegisterController.php'; 
require __DIR__ . '/controllers/LogoutController.php'; 
require __DIR__ . '/controllers/LoginController.php'; 
require __DIR__ . '/controllers/WinnersController.php';
require __DIR__ . '/controllers/AdminController.php';
require __DIR__ . '/middlewares/AuthMiddleware.php';
require __DIR__ . '/controllers/DashboardController.php';
require __DIR__ . '/models/Statistics.php';
require __DIR__ . '/controllers/StatisticsController.php';
require __DIR__ . '/models/Ranking.php';
require __DIR__ . '/controllers/RankingController.php';
require __DIR__ . '/controllers/SearchController.php';
require __DIR__ . '/controllers/GatewayController.php';
require_once __DIR__ . '/models/Gateway.php';

use controller\CampaignController;
use controller\PurchaseController;
use controller\CommunicationController;
use controller\TermsOfUseController;
use controller\OrdersController;
use controller\RegisterController;
use controller\LogoutController;
use controller\LoginController;
use controller\WinnersController;
use controller\AdminController;
use middlewares\AuthMiddleware;
use controller\DashboardController;
use controller\StatisticsController;
use controller\RankingController;
use controller\UserController;
use controller\SearchController;
use controller\GatewayController;

$campaignController = new CampaignController($pdo);
$purchaseController = new PurchaseController($pdo);
$communicationController = new CommunicationController($pdo);
$termsOfUseController = new TermsOfUseController();
$ordersController = new OrdersController($pdo);
$registerController = new RegisterController($pdo);
$logoutController = new LogoutController();
$loginController = new LoginController($pdo);
$winnersController = new WinnersController($pdo);
$adminController = new AdminController($pdo);
$authMiddleware = new AuthMiddleware();
$dashboardController = new DashboardController($pdo);
$statisticsController = new StatisticsController($pdo); 
$rankingController = new RankingController($pdo); 
$userController = new UserController($pdo);
$searchController = new SearchController($pdo);
$gatewayController = new GatewayController($pdo);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['settings'])) {
    $settingsController = new SettingsController($pdo);
    $_SESSION['settings'] = $settingsController->getSettings();
}


if (!isset($_SESSION['efiBankConfig']) || !isset($_SESSION['paggueConfig'])) {
    $gatewayController = new GatewayController($pdo);
    $gateways = $gatewayController->getGateways();

    if (isset($gateways) && count($gateways) > 0) {
        $_SESSION['efiBankConfig'] = [
            'client_id' => $gateways[0]['client_id'],
            'client_secret' => $gateways[0]['client_secret'],
            'sandbox' => false,
            'pix_key' => $gateways[0]['pix_key'],
            'pix_cert' => $gateways[0]['pix_cert']
        ];

        if (isset($gateways[1])) {
            $_SESSION['paggueConfig'] = [
                'client_key' => $gateways[1]['client_id'],
                'client_secret' => $gateways[1]['client_secret'],
                'api_url' => $gateways[1]['api_url'],
                'company_id' => $gateways[1]['company_id']
            ];
        }
    } else {
        $_SESSION['efiBankConfig'] = null;
        $_SESSION['paggueConfig'] = null;
    }
}




function route($uri) {
    global $campaignController, $purchaseController, $communicationController, $termsOfUseController, $ordersController, $registerController, $logoutController, $loginController, $winnersController,
    $adminController, $authMiddleware, $dashboardController, $statisticsController, $rankingController,
    $userController, $settingsController, $searchController, $gatewayController;

    $parsedUrl = parse_url($uri);
    $path = $parsedUrl['path'];
    $segments = explode('/', trim($path, '/'));

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $path == '/compra') {
        session_start();
        $data = $_POST;
    
        $user = $purchaseController->checkPhone($data['phone']);
        if ($user) {
            $_SESSION['user'] = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'image_user' => $user['image_user']
            ];
    
            $data['id_user'] = $user['id'];
    
            $order = $purchaseController->createOrder($data);
    
            header('Location: /compra/' . $order['pix_url']);
            exit();
        } else {
            header('Location: /register');
            exit();
        }
    }
    
    

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $path == '/get-expiration-time') {
        $pixUrl = $_GET['pix_url'];
        $expirationTime = $purchaseController->getExpirationTime($pixUrl);
        echo json_encode(['expiration_time' => $expirationTime]);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && preg_match('#^/compra/([^/]+)$#', $path, $matches)) {
        $pixUrl = $matches[1];
        $purchaseController->showOrder($pixUrl);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $path == '/check-phone') {
        $phone = $_GET['phone'];

        error_log("Recebido /check-phone com telefone: " . $phone);

        $user = $purchaseController->checkPhone($phone);

        header('Content-Type: application/json');
        if ($user) {
            error_log("Usuário encontrado para o telefone: " . $phone);
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            error_log("Nenhum usuário encontrado para o telefone: " . $phone);
            echo json_encode(['success' => false]);
        }
        exit();
    }

    


    if ($_SERVER['REQUEST_METHOD'] == 'GET' && preg_match('#^/dashboard/campaign/edit-(\d+)$#', $path, $matches)) {
        $authMiddleware->handle();
        $id = $matches[1];
        $campaignController->editCampaign($id);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && preg_match('/^\/obrigado\/([^\/]+)$/', $path, $matches)) {
        $pix_url = $matches[1];
        $purchaseController->showThankYouPage($pix_url);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($path, '/dashboard/campaign/edit/') === 0) {
        $id = substr($path, strlen('/dashboard/campaign/edit/'));
        $campaignController->updateCampaign($id);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($path, '/dashboard/user/edit') === 0) {
        $userController->updateUser();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($path, '/dashboard/order/cancel') === 0) {
        $ordersController->cancelOrder();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($path, '/dashboard/order/confirm') === 0) {
        $ordersController->confirmOrder();
    }
    
    if ($path == '/') {
        $campaignController->index();
    } elseif ($segments[0] == 'campanha' && isset($segments[1])) {
        $slug = $segments[1];
        $campaignController->show($slug);
    } elseif ($path == '/campanhas') {
        $campaignController->listCampaigns();
    } elseif ($path == '/comunicados') {
        $communicationController->index();
    } elseif ($path == '/termo-de-uso') {
        $termsOfUseController->index();
    } elseif ($path == '/meus-numeros') {
        $ordersController->showOrders();
    } elseif ($path == '/cadastrar') {
        $registerController->showForm();
    } elseif ($path == '/register') {
        $registerController->registerUser();
    } elseif ($path == '/login') {
        $loginController->showForm();
    } elseif ($path == '/loginUser') {
        $loginController->loginUser();
    } elseif ($path == '/logout') {
        $logoutController->logout();
        exit();
    } elseif ($path == '/ganhadores') {
        $winnersController->showWinners();
        exit();
    } elseif ($path == '/contato') {
        require __DIR__ . '/views/pages/contato.php';
        exit();
    } elseif ($path == '/dashboard/login') {
        require __DIR__ . '/views/dashboard/login.php';
        exit();
    } elseif ($path == '/loginAdmin') {
        $adminController->loginAdmin();
        exit();
    }elseif ($path == '/dashboard/home') {
        $authMiddleware->handle();
        $data = $dashboardController->getDashboardData();
        require __DIR__ . '/views/dashboard/home.php';
        exit();
    }elseif ($path == '/dashboard/campaigns') {
        $authMiddleware->handle();
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $campaigns = $campaignController->getAllCampaigns($status);
        require __DIR__ . '/views/dashboard/campaigns.php';
        exit();
    } 
     elseif ($path == '/dashboard/delete-campaign') {
        $authMiddleware->handle();
        $campaignController->deleteCampaign($_POST['id']);
        header('Location: /dashboard/campaigns');
        exit();
    } elseif ($path == '/dashboard/search-winner') {
        $authMiddleware->handle();
        $winnerData = $campaignController->searchWinner($_GET['campaign_id'], $_GET['title_number']);
        echo json_encode($winnerData);
        exit();
    } elseif ($path == '/dashboard/orders') {
        $authMiddleware->handle();
        $ordersController->showAllOrders();
        exit();
    } elseif ($path == '/api/campaigns') {
        $authMiddleware->handle();
        $ordersController->getAllCampaigns();
        exit();
    } elseif ($path == '/dashboard/delete-order') {
        $authMiddleware->handle();
        $ordersController->deleteOrder();
        exit();
    }elseif (preg_match('/^\/dashboard\/order\/edit-(\d+)$/', $path, $matches)) {
        $authMiddleware->handle();
        $id = $matches[1];
        $ordersController->editOrder($id);
        exit();    
    } elseif ($path == '/dashboard/statistics') {
        $authMiddleware->handle();
        $statisticsController->showStatistics();
        exit();
    }elseif ($path == '/dashboard/ranking') {
        $authMiddleware->handle();
        $rankingController->showRanking();
        exit();
    } elseif ($path == '/dashboard/communications') {
        $authMiddleware->handle();
        $communicationController->showDashboardCommunications();
        exit();
    } elseif ($path == '/dashboard/add-communication') {
        $authMiddleware->handle();
        $communicationController->addCommunication();
        exit();
    } elseif ($path == '/dashboard/update-communication') {
        $authMiddleware->handle();
        $communicationController->updateCommunication();
        exit();
    } elseif ($path == '/dashboard/delete-communication') {
        $authMiddleware->handle();
        $communicationController->deleteCommunication();
        exit();
    } elseif ($path == '/dashboard/users') {
        $authMiddleware->handle();
        $userController->showUsers();
        exit();
    } elseif ($path == '/dashboard/delete-user') {
        $authMiddleware->handle();
        $userController->deleteUser();
        exit();
    }elseif ($path == '/dashboard/settings') {
        $authMiddleware->handle();
        require __DIR__ . '/views/dashboard/settings.php';
        exit();
    }elseif ($path == '/dashboard/update-settings') {
        $authMiddleware->handle();
        $settingsController->updateSettings();
        exit();
    } elseif ($path == '/dashboard/search') {
        $authMiddleware->handle();
        $searchController->search();
        exit();
    } elseif ($path == '/dashboard/campaign/new') {
        $authMiddleware->handle();
        require __DIR__ . '/views/dashboard/newcampaign.php';
        exit();
    } elseif ($path == '/dashboard/campaign/create') {
        $authMiddleware->handle();
        $campaignController->createCampaign();
        exit();   
    } elseif ($path == '/dashboard/gateways') {
        $authMiddleware->handle();
        $gatewayController->showGateways();
        exit();
    } elseif ($path == '/api/update-gateway') {
        $gatewayController->updateGateway();
        exit();
    } else {
        include __DIR__ . '/views/pages/404.php';
        exit();
    }
    
    
}

$uri = $_SERVER['REQUEST_URI'];
route($uri);

?>

