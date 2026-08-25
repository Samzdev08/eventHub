<?php

namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

use App\Config\Database;
use PDO;

class RegistrationModel
{

      public static function getRegistrationsByUserId($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT id, user_id, event_id, created_at
            FROM registrations
            WHERE user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}