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

    public static function getEventById($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT id, title, description, event_date, capacity, owner_id
            FROM events
            WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getEventByUserId($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            SELECT id, title, description, event_date, capacity,  owner_id
            FROM events 
            WHERE owner_id = :id");
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createEvent($data)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO events (title, description, event_date, capacity, owner_id) 
            VALUES (:title, :description, :event_date, :capacity, :owner_id)");
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':event_date' => $data['event_date'],
            ':capacity' => $data['capacity'],
            ':owner_id' => $data['owner_id']
        ]);

        return $pdo->lastInsertId();
    }

    public static function updateEvent($id, $data)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            UPDATE events 
            SET title = :title, description = :description, event_date = :event_date, capacity = :capacity
            WHERE id = :id");
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':event_date' => $data['event_date'],
            ':capacity' => $data['capacity'],
            ':id' => $id
        ]);

        
    }

    public static function deleteEvent($id)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    
}