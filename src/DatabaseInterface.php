<?php

namespace App\Interfaces;

interface DatabaseInterface {
    /**
     * Get user array from database by email
     * @param string $email
     * @return array|false
     */
    public function getUserByEmail($email);
}
