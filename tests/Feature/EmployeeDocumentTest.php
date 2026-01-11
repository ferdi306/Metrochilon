<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeeDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_and_delete_document()
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $employee = User::factory()->create(['role' => 'karyawan']);

        $file = UploadedFile::fake()->create('ktp.jpg', 200, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.employees.documents.store', $employee->id), [
            'file' => $file,
            'type' => 'ktp',
        ]);

        $response->assertSessionHas('status');

        $this->assertDatabaseCount('employee_documents', 1);

        $doc = \App\Models\EmployeeDocument::first();

        // download
        $this->actingAs($admin)->get(route('admin.employees.documents.download', [$employee->id, $doc->id]))->assertStatus(200);

        // delete
        $this->actingAs($admin)->delete(route('admin.employees.documents.destroy', [$employee->id, $doc->id]))->assertSessionHas('status');

        $this->assertDatabaseCount('employee_documents', 0);
    }
}
