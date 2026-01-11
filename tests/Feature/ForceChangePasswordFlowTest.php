<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForceChangePasswordFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_logs_in_with_temp_password_and_is_forced_to_change_it()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employee = User::factory()->create(['role' => 'karyawan']);

        // Admin generates temp password
        $resp = $this->actingAs($admin)->post(route('admin.employees.temp_password', $employee->id));
        $resp->assertSessionHas('temp_password');
        $temp = $resp->getSession()->get('temp_password');

        // Logout admin to allow employee to login as guest
        $this->post('/logout');

        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'must_change_password' => 1,
        ]);

        // Ensure the password stored matches the temp password
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check($temp, $employee->fresh()->password));

        // Employee can login with temp password and is redirected to force change page
        $login = $this->post('/login', ['email' => $employee->email, 'password' => $temp]);
        $this->assertAuthenticatedAs($employee);
        $login->assertSessionHasNoErrors();

        // The login should redirect to force-change page when must_change_password = true
        $this->assertEquals(route('password.force', [], true), $login->getTargetUrl());

        // Employee posts new password
        $this->actingAs($employee)->post(route('password.force.update'), [
            'password' => 'newsecurepassword',
            'password_confirmation' => 'newsecurepassword',
        ])->assertRedirect(route('karyawan.dashboard'));

        $this->assertDatabaseHas('users', [
            'id' => $employee->id,
            'must_change_password' => 0,
        ]);
    }
}
