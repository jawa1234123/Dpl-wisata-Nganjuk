<?php

namespace App\Services;

use App\Interfaces\DatabaseInterface;

class UserService {
    private $db;

    public function __construct(DatabaseInterface $db) {
        $this->db = $db;
    }

    public function login($email, $password) {
        $user = $this->db->getUserByEmail($email);
        
        // Memverifikasi password (asumsi menggunakan password_hash di database)
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
}
