<?php
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase {

    protected function setUp(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
    }

    public function testCsrfTokenGeneration() {
        if (session_id() == '') {
            session_start();
        }
        $token = Session::csrf_token();
        $this->assertNotEmpty($token);
        $this->assertEquals(64, strlen($token));
        
        $token2 = Session::csrf_token();
        $this->assertEquals($token, $token2);
    }

    public function testCsrfVerification() {
        if (session_id() == '') {
            session_start();
        }
        $token = Session::csrf_token();
        $this->assertTrue(Session::verify_csrf($token));
    }

    public function testCsrfVerificationFailsWithInvalidToken() {
        if (session_id() == '') {
            session_start();
        }
        Session::csrf_token();
        $this->assertFalse(Session::verify_csrf('invalid_token'));
    }

    public function testCsrfInputRendersHiddenField() {
        if (session_id() == '') {
            session_start();
        }
        $input = Session::csrf_input();
        $this->assertStringContainsString('<input type="hidden"', $input);
        $this->assertStringContainsString('csrf_token', $input);
    }

    public function testCsrfMetaRendersMetaTag() {
        if (session_id() == '') {
            session_start();
        }
        $meta = Session::csrf_meta();
        $this->assertStringContainsString('<meta name="csrf-token"', $meta);
    }
}
