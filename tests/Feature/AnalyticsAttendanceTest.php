<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AnalyticsAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_daily_attendance_summary_returns_counts_for_month()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $employee1 = User::factory()->create(['role' => 'karyawan']);
        $employee2 = User::factory()->create(['role' => 'karyawan']);

        // Create attendances: employee1 present on 2026-01-05 and 06, employee2 on 05
        $a1 = Attendance::create(['user_id' => $employee1->id, 'type' => 'in', 'photo_path' => 'p.jpg']);
        $a1->created_at = '2026-01-05 08:00:00';
        $a1->save();

        $a2 = Attendance::create(['user_id' => $employee1->id, 'type' => 'in', 'photo_path' => 'p.jpg']);
        $a2->created_at = '2026-01-06 08:05:00';
        $a2->save();

        $a3 = Attendance::create(['user_id' => $employee2->id, 'type' => 'in', 'photo_path' => 'p.jpg']);
        $a3->created_at = '2026-01-05 08:10:00';
        $a3->save();



        // Leaves: employee1 sakit on 2026-01-10, employee2 izin on 2026-01-05
        Leave::create(['user_id' => $employee1->id, 'type' => 'sakit', 'start_date' => '2026-01-10', 'end_date' => '2026-01-10', 'days' => 1, 'status' => 'approved', 'reason' => 'sakit']);
        Leave::create(['user_id' => $employee2->id, 'type' => 'izin', 'start_date' => '2026-01-05', 'end_date' => '2026-01-05', 'days' => 1, 'status' => 'approved', 'reason' => 'keperluan keluarga']);

        $resp = $this->actingAs($admin)->getJson('/admin/api/analytics/attendance/daily?month=2026-01');
        $resp->assertOk();


        $json = $resp->json();
        $this->assertArrayHasKey('labels', $json);
        $this->assertArrayHasKey('present', $json);
        $this->assertArrayHasKey('izin', $json);
        $this->assertArrayHasKey('sakit', $json);

        // Check specific days
        $labels = $json['labels'];
        $index05 = array_search('2026-01-05', $labels);
        $index06 = array_search('2026-01-06', $labels);
        $index10 = array_search('2026-01-10', $labels);

        $this->assertNotFalse($index05);
        $this->assertEquals(2, $json['present'][$index05]); // two distinct users
        $this->assertEquals(1, $json['izin'][$index05]);

        $this->assertNotFalse($index06);
        $this->assertEquals(1, $json['present'][$index06]);

        $this->assertNotFalse($index10);
        $this->assertEquals(1, $json['sakit'][$index10]);
    }
}
