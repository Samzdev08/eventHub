<?php

namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

use App\Config\Database;
use PDO;

class UserModel
{

    public static function createUser($data)
    {

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO users (username, password_hash, role) 
            VALUES ( :username, :password_hash, :role)");
        $stmt->execute([
            ':username' => $data['username'],
            ':password_hash' => $data['password'],
            ':role' => $data['role']
        ]);

        return $pdo->lastInsertId();
    }

    public static function userExists($username)
    {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->execute([
            ':username' => $username
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public static function login($data){

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :username");
        $stmt->execute([
            ':username' => $data['username']
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$user){

           
            return false;
        }
        else{

            if(password_verify($data['password'], $user['password_hash'])){

                $_SESSION['user'] = [
    
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
               

                return true;
            }
            else{
                
                return false;
            }
        }


    }
}
