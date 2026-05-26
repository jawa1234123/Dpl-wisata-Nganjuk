<?php

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Interfaces\DatabaseInterface;

require_once __DIR__ . '/../src/DatabaseInterface.php';
require_once __DIR__ . '/../src/UserService.php';

class UserServiceTest extends TestCase {
    
    private $dbMock;
    private $userService;

    /**
     * setUp() dipanggil secara otomatis SEBELUM setiap method test dijalankan.
     * Ini digunakan untuk menyiapkan environment yang sama agar tidak perlu menulis kode berulang.
     */
    protected function setUp(): void {
        $this->dbMock = $this->createMock(DatabaseInterface::class);
        $this->userService = new UserService($this->dbMock);
    }

    public function testLoginSuccess() {
        // Memastikan method getUserByEmail dipanggil persis 1 kali
        $this->dbMock->expects($this->once())
               ->method('getUserByEmail')
               ->with('user@example.com')
               ->willReturn([
                   'id' => 1,
                   'email' => 'user@example.com',
                   'password' => password_hash('rahasia123', PASSWORD_DEFAULT)
               ]);
               
        $result = $this->userService->login('user@example.com', 'rahasia123');
        
        // Assertions yang lebih spesifik
        $this->assertIsArray($result, "Login harus mengembalikan array data user");
        $this->assertArrayHasKey('id', $result, "Array hasil harus memiliki key 'id'");
        $this->assertEquals('user@example.com', $result['email']);
    }

    public function testLoginFailureEmailNotFound() {
        // Skenario: Database tidak menemukan user (mengembalikan null)
        $this->dbMock->method('getUserByEmail')
               ->willReturn(null);
               
        $result = $this->userService->login('unknown@example.com', 'password123');
        
        $this->assertFalse($result, "Login harus gagal jika email tidak ditemukan");
    }

    /**
     * @dataProvider invalidLoginProvider
     * 
     * Menggunakan Data Provider untuk menguji banyak skenario kegagalan sekaligus 
     * tanpa harus menulis ulang method yang mirip-mirip berkali-kali.
     */
    public function testLoginFailuresWithProvider($email, $password, $dbReturnValue) {
        $this->dbMock->method('getUserByEmail')
               ->willReturn($dbReturnValue);

        $result = $this->userService->login($email, $password);

        $this->assertFalse($result, "Login harus gagal untuk skenario password/email salah");
    }

    /**
     * Method ini menyediakan array berisi skenario data untuk diuji di testLoginFailuresWithProvider
     */
    public static function invalidLoginProvider() {
        $validDbUser = [
            'id' => 2,
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ];

        return [
            'Skenario: Password Salah'  => ['test@example.com', 'salahpassword', $validDbUser],
            'Skenario: Password Kosong' => ['test@example.com', '', $validDbUser]
        ];
    }
}
