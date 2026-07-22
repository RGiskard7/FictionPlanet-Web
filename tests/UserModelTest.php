<?php
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase {

    public function testUserModelConstructorAndGetters() {
        $user = new UserModel(
            1, 'johndoe', 'John', 'Doe', 'john@test.com',
            'hashed_password', '123 Main St', 'USA', '123456789',
            1, true, '2024-01-01', '2024-06-01', '2024-06-15'
        );

        $this->assertEquals(1, $user->get_id());
        $this->assertEquals('johndoe', $user->get_user_name());
        $this->assertEquals('John', $user->get_first_name());
        $this->assertEquals('Doe', $user->get_last_name());
        $this->assertEquals('john@test.com', $user->get_email());
        $this->assertEquals('hashed_password', $user->get_password());
        $this->assertEquals('123 Main St', $user->get_address());
        $this->assertEquals('USA', $user->get_country());
        $this->assertEquals('123456789', $user->get_phone_number());
        $this->assertEquals(1, $user->get_role());
        $this->assertTrue($user->is_active());
        $this->assertEquals('2024-01-01', $user->get_reg_date());
        $this->assertEquals('2024-06-01', $user->get_last_update_date());
        $this->assertEquals('2024-06-15', $user->get_last_access_date());
    }

    public function testSettersUpdateValues() {
        $user = new UserModel(0, '', '', '', '', '', '', '', '', 0, false, '', '', '');
        
        $user->set_user_name('janedoe');
        $this->assertEquals('janedoe', $user->get_user_name());
        
        $user->set_first_name('Jane');
        $this->assertEquals('Jane', $user->get_first_name());
        
        $user->set_last_name('Smith');
        $this->assertEquals('Smith', $user->get_last_name());
        
        $user->set_email('jane@test.com');
        $this->assertEquals('jane@test.com', $user->get_email());
        
        $user->set_password('newpass');
        $this->assertEquals('newpass', $user->get_password());
        
        $user->set_active(true);
        $this->assertTrue($user->is_active());
        
        $user->set_phone_number('987654321');
        $this->assertEquals('987654321', $user->get_phone_number());
    }

    public function testContactModelFixedSetter() {
        $contact = new ContactModel(0, 1, 2, '2024-01-01');
        
        $contact->set_contact_id(42);
        $this->assertEquals(42, $contact->get_contact_id());
    }
}
