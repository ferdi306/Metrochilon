<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeDocumentController extends Controller
{
    public function store(Request $request, $userId)
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
            'type' => 'required|in:contract,ktp,npwp,other',
        ]);

        $user = User::findOrFail($userId);

        $file = $request->file('file');
        $original = $file->getClientOriginalName();
        $path = $file->storePublicly('employee_documents/' . $user->id, 'public');

        $doc = EmployeeDocument::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'path' => $path,
            'original_name' => $original,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('status', 'Dokumen berhasil diupload.');
    }

    public function download($userId, $id)
    {
        $doc = EmployeeDocument::where('user_id', $userId)->findOrFail($id);
        return Storage::disk('public')->download($doc->path, $doc->original_name);
    }

    public function destroy($userId, $id)
    {
        $doc = EmployeeDocument::where('user_id', $userId)->findOrFail($id);
        Storage::disk('public')->delete($doc->path);
        $doc->delete();
        return back()->with('status', 'Dokumen dihapus.');
    }
}