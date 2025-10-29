<?php

namespace models;

class Settings {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getSettingsById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM settings WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateSettings($id, $data) {
        $stmt = $this->pdo->prepare('
            UPDATE settings SET 
                name_website = ?, 
                support_wpp = ?, 
                group_wpp = ?, 
                instagram = ?, 
                tiktok = ?, 
                telegram = ?, 
                color_website = ?, 
                id_pixel_facebook = ?, 
                tag_google = ?, 
                term_use = ?, 
                field_cpf = ?, 
                field_email = ?, 
                field_age = ?, 
                field_address = ?, 
                paggue = ?, 
                efi_bank = ?, 
                image_logo = ?, 
                image_icon = ?, 
                created_at = ?, 
                updated_at = ?
            WHERE id = ?');

        $stmt->execute([
            $data['name_website'], 
            $data['support_wpp'], 
            $data['group_wpp'], 
            $data['instagram'], 
            $data['tiktok'], 
            $data['telegram'], 
            $data['color_website'], 
            $data['id_pixel_facebook'], 
            $data['tag_google'], 
            $data['term_use'], 
            $data['field_cpf'], 
            $data['field_email'], 
            $data['field_age'], 
            $data['field_address'], 
            $data['paggue'], 
            $data['efi_bank'], 
            $data['image_logo'], 
            $data['image_icon'], 
            $data['created_at'], 
            $data['updated_at'], 
            $id
        ]);
    }
}
?>
