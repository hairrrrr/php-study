<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function testRegisterValidCredentials(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'test',
            'last_name' => 'test',
            'email' => 'test@example.com',
            'password' => 'abc123',
            'password_confirmation' => 'abc123'
        ]);

        $response->assertRedirect('/notes');
    }
}
