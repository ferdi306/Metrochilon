<div style="display:flex; gap:8px; align-items:center;">
    <a href="{{ route('admin.export.attendance.daily', ['month' => date('Y-m')]) }}" class="btn btn-sm">Export CSV (Daily)</a>
    <a href="{{ route('admin.export.attendance.monthly', ['year' => date('Y')]) }}" class="btn btn-sm">Export CSV (Monthly)</a>
</div>