<?php 

namespace controller;

use models\Settings;

class SettingsController {
    private $settingsModel;

    public function __construct($pdo) {
        $this->settingsModel = new Settings($pdo);
    }

    public function updateSettings() {
        $id = $_POST['id'];
        $data = [
            'name_website' => $_POST['name_website'] ?? ' ',
            'support_wpp' => $_POST['support_wpp'],
            'group_wpp' => $_POST['group_wpp'],
            'instagram' => $_POST['instagram'],
            'tiktok' => $_POST['tiktok'],
            'telegram' => $_POST['telegram'],
            'color_website' => $_POST['color_website'],
            'id_pixel_facebook' => $_POST['id_pixel_facebook'],
            'tag_google' => $_POST['tag_google'],
            'term_use' => $_POST['term_use'],
            'field_cpf' => isset($_POST['field_cpf']) ? 1 : 0,
            'field_email' => isset($_POST['field_email']) ? 1 : 0,
            'field_age' => isset($_POST['field_age']) ? 1 : 0,
            'field_address' => isset($_POST['field_address']) ? 1 : 0,
            'paggue' => isset($_POST['paggue']) && $_POST['paggue'] ? 1 : 0,
            'efi_bank' => isset($_POST['efi_bank']) && $_POST['efi_bank'] ? 1 : 0,
            'image_logo' => $_FILES['image_logo']['name'] ? $this->uploadImage('image_logo') : $_POST['image_logo_old'],
            'image_icon' => $_FILES['image_icon']['name'] ? $this->uploadImage('image_icon') : $_POST['image_icon_old'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->settingsModel->updateSettings($id, $data);
        $_SESSION['settings'] = $this->settingsModel->getSettingsById($id);
        header('Location: /dashboard/settings');
    }

    private function uploadImage($inputName) {
        $file = $_FILES[$inputName];
    
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return $_POST[$inputName . '_old'];
        }
    
        $fileName = uniqid() . '-' . basename($file['name']);
        $targetDir =  __DIR__ . '/../public/images/';
        $targetFile = $targetDir . $fileName;
    
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        } else {
            return $_POST[$inputName . '_old'];
        }
    }

    public function getSettings() {
        return $this->settingsModel->getSettingsById(1);
    }   
}

?>
