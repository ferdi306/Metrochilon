<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTempPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_temporary_password_for_employee()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employee = User::factory()->create(['role' => 'karyawan', 'must_change_password' => false]);

        \Illuminate\Support\Facades\Notification::fake();

        $response = $this->actingAs($admin)->post(route('admin.employees.temp_password', $employee->id));

        $response->assertSessionHas('temp_password');
        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'must_change_password' => 1,
        ]);

        // Assert notification was sent
        \Illuminate\Support\Facades\Notification::assertSentTo(
            [$employee],
            \App\Notifications\TemporaryPasswordNotification::class
        );
    }
}
