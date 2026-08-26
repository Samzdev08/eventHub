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
            SELECT r.id, r.user_id, r.event_id, e.title, e.description, e.event_date, e.owner_id
            FROM registrations r
            JOIN events e ON r.event_id = e.id
            WHERE r.user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public static function createRegistration($userId, $eventId)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO registrations (user_id, event_id)
            VALUES (:user_id, :event_id)");
        return $stmt->execute([
            ':user_id' => $userId,
            ':event_id' => $eventId
        ]);
    }

    
}