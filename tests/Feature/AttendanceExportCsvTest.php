<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceExportCsvTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_export_daily_summary_csv()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $u1 = User::factory()->create(['role' => 'karyawan']);
        $u2 = User::factory()->create(['role' => 'karyawan']);

        // attendances for Jan 5 and Jan 6
        $a1 = Attendance::create(['user_id' => $u1->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a1->created_at = '2026-01-05 08:00:00'; $a1->save();
        $a2 = Attendance::create(['user_id' => $u2->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a2->created_at = '2026-01-05 08:10:00'; $a2->save();
        $a3 = Attendance::create(['user_id' => $u1->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a3->created_at = '2026-01-06 08:05:00'; $a3->save();

        $resp = $this->actingAs($admin)->get('/admin/export/attendance/daily?month=2026-01');
        $resp->assertStatus(200);
        $resp->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $content = $resp->streamedContent();

        // check header row present
        $this->assertStringContainsString('date,present,izin,sakit', $content);
        $this->assertStringContainsString('2026-01-05,2,0,0', $content);
        $this->assertStringContainsString('2026-01-06,1,0,0', $content);
    }

    public function test_admin_can_export_monthly_summary_csv()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $u1 = User::factory()->create(['role' => 'karyawan']);

        // one attendance in Jan and two in Feb
        $a1 = Attendance::create(['user_id' => $u1->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a1->created_at = '2026-01-10 08:00:00'; $a1->save();
        $a2 = Attendance::create(['user_id' => $u1->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a2->created_at = '2026-02-05 08:00:00'; $a2->save();
        $a3 = Attendance::create(['user_id' => $u1->id, 'type' => 'in', 'photo_path' => 'p.jpg']); $a3->created_at = '2026-02-06 08:00:00'; $a3->save();

        $resp = $this->actingAs($admin)->get('/admin/export/attendance/monthly?year=2026');
        $resp->assertStatus(200);
        $resp->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $content = $resp->streamedContent();

        $this->assertStringContainsString('month,present,izin,sakit', $content);
        $this->assertStringContainsString('2026-01,1,0,0', $content);
        $this->assertStringContainsString('2026-02,2,0,0', $content);
    }
}
