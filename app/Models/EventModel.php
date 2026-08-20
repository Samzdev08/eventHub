<?php

namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

use App\Config\Database;
use PDO;

class EventModel
{
    public static function getAllEvent()
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT id, title, description, event_date, capacity,  owner_id
            FROM events");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}