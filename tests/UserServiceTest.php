<?php

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Interfaces\DatabaseInterface;

require_once __DIR__ . '/../src/DatabaseInterface.php';
require_once __DIR__ . '/../src/UserService.php';

class UserServiceTest extends TestCase {
    
    public function testLoginSuccessWithMock() {
        // Membuat object MOCK sebagai Test Double dari DatabaseInterface
        $dbMock = $this->createMock(DatabaseInterface::class);
        
        // Mendefinisikan ekspektasi (expectation) dari mock:
        // method 'getUserByEmail' akan dipanggil 1 kali dengan argumen 'user@example.com'
        $dbMock->expects($this->once())
               ->method('getUserByEmail')
               ->with('user@example.com')
               ->willReturn([
                   'id' => 1,
                   'email' => 'user@example.com',
                   // Password asli adalah 'rahasia123'
                   'password' => password_hash('rahasia123', PASSWORD_DEFAULT)
               ]);
               
        // Menginjeksi mock object ke dalam UserService (Dependency Injection)
        $userService = new UserService($dbMock);
        
        // Menjalankan method login yang akan diuji
        $result = $userService->login('user@example.com', 'rahasia123');
        
        // Assertion: memastikan hasil login berhasil dan mengembalikan data user
        $this->assertIsArray($result, "Login harusnya berhasil dan mengembalikan array data user");
        $this->assertEquals('user@example.com', $result['email']);
    }

    public function testLoginFailureWrongPasswordWithMock() {
        // Membuat object MOCK sebagai Test Double dari DatabaseInterface
        $dbMock = $this->createMock(DatabaseInterface::class);
        
        // Mengatur mock agar mengembalikan data user tertentu
        $dbMock->method('getUserByEmail')
               ->willReturn([
                   'id' => 2,
                   'email' => 'test@example.com',
                   'password' => password_hash('password123', PASSWORD_DEFAULT)
               ]);
               
        $userService = new UserService($dbMock);
        
        // Menjalankan method login dengan password yang salah
        $result = $userService->login('test@example.com', 'salahpassword');
        
        // Assertion: memastikan hasil login gagal (false) karena password salah
        $this->assertFalse($result, "Login harusnya gagal karena password salah");
    }
}
