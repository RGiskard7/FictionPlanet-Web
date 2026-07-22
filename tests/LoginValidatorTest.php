<?php
use PHPUnit\Framework\TestCase;

class LoginValidatorTest extends TestCase {

    private $connection;

    protected function setUp(): void {
        $this->connection = $this->createMock(PDO::class);
    }

    public function testEmptyEmailAndPasswordProducesError() {
        $validator = new LoginValidator($this->connection, '', '');
        $this->assertNotEmpty($validator->get_error());
        $this->assertNull($validator->get_user());
    }

    public function testEmptyPasswordProducesError() {
        $validator = new LoginValidator($this->connection, 'test@test.com', '');
        $this->assertNotEmpty($validator->get_error());
    }

    public function testEmptyEmailProducesError() {
        $validator = new LoginValidator($this->connection, '', 'password123');
        $this->assertNotEmpty($validator->get_error());
    }

    public function testValidInputDoesNotProduceErrorBeforeDbCheck() {
        $validator = new LoginValidator($this->connection, 'test@test.com', 'password123');
        $error = $validator->get_error();
        $this->assertNotSame('Debes introducir tu email y tu contraseña.', $error);
    }
}
