<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_register_and_is_logged_in()
    {
        $response = $this->post('/register', [
            'name' => 'Test Employee',
            'email' => 'employee_test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'employee_id' => 'EMP-001',
            'phone' => '08123456789',
            'address' => 'Jakarta',
        ]);

        $response->assertRedirect(route('karyawan.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'employee_test@example.com',
            'role' => 'karyawan',
            'status' => 'active',
        ]);

        $this->assertAuthenticated();
    }
}
