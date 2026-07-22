<?php
use PHPUnit\Framework\TestCase;

class NewUserValidatorTest extends TestCase {

    private $connection;

    protected function setUp(): void {
        $this->connection = $this->createMock(PDO::class);
    }

    public function testEmptyUserNameProducesError() {
        $validator = new NewUserValidator('', '', '', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_user_name());
    }

    public function testShortUserNameProducesError() {
        $validator = new NewUserValidator('abc', '', '', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_user_name());
    }

    public function testLongUserNameProducesError() {
        $longName = str_repeat('a', 25);
        $validator = new NewUserValidator($longName, '', '', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_user_name());
    }

    public function testEmptyFirstNameProducesError() {
        $validator = new NewUserValidator('username1', '', '', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_first_name());
    }

    public function testShortFirstNameProducesError() {
        $validator = new NewUserValidator('username1', 'A', '', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_first_name());
    }

    public function testEmptyEmailProducesError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', '', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_email());
    }

    public function testEmptyPasswordsProduceError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', 'test@test.com', '', '', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_password1());
        $this->assertNotEmpty($validator->get_error_password2());
    }

    public function testMismatchedPasswordsProduceError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', 'test@test.com', 'pass1', 'pass2', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_password2());
    }

    public function testEmptyAddressProducesError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', 'test@test.com', 'pass1', 'pass1', '', '', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_address());
    }

    public function testEmptyPhoneNumberProducesError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', 'test@test.com', 'pass1', 'pass1', 'Addr', 'Country', '', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_phone_number());
    }

    public function testRoleZeroProducesError() {
        $validator = new NewUserValidator('username1', 'John', 'Doe', 'test@test.com', 'pass1', 'pass1', 'Addr', 'Country', '123456789', 0, $this->connection);
        $this->assertNotEmpty($validator->get_error_role());
    }

    public function testValidFormWithAllFields() {
        $validator = new NewUserValidator('newuser123', 'John', 'Doe', 'john@example.com', 'mypassword', 'mypassword', '123 Main St', 'Spain', '600111222', 1, $this->connection);
        $this->assertEmpty($validator->get_error_user_name());
        $this->assertEmpty($validator->get_error_first_name());
        $this->assertEmpty($validator->get_error_last_name());
        $this->assertEmpty($validator->get_error_email());
        $this->assertEmpty($validator->get_error_password1());
        $this->assertEmpty($validator->get_error_password2());
        $this->assertEmpty($validator->get_error_address());
        $this->assertEmpty($validator->get_error_country());
        $this->assertEmpty($validator->get_error_phone_number());
        $this->assertEmpty($validator->get_error_role());
        $this->assertTrue($validator->valid_form());
    }

    public function testValidFormPopulatesAllFields() {
        $validator = new NewUserValidator('newuser123', 'Elon', 'Musk', 'elon@spacex.com', 'rocket1', 'rocket1', '1 Mars Rd', 'USA', '555123456', 1, $this->connection);
        $this->assertEquals('newuser123', $validator->get_user_name());
        $this->assertEquals('Elon', $validator->get_first_name());
        $this->assertEquals('Musk', $validator->get_last_name());
        $this->assertEquals('elon@spacex.com', $validator->get_email());
        $this->assertEquals('rocket1', $validator->get_password());
        $this->assertEquals('1 Mars Rd', $validator->get_address());
        $this->assertEquals('USA', $validator->get_country());
        $this->assertEquals('555123456', $validator->get_phone_number());
        $this->assertEquals(1, $validator->get_role());
    }
}
