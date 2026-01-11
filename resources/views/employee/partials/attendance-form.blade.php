<form method="POST" action="{{ route('attendance.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Absen</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="in">Masuk</option>
                <option value="out">Pulang</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
            <input type="file" name="photo" accept="image/*" capture="environment" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                   required>
            <small class="text-gray-500 text-xs mt-1 block">Gunakan kamera untuk hasil terbaik</small>
        </div>
    </div>
    <input type="hidden" name="latitude" id="lat">
    <input type="hidden" name="longitude" id="lng">
    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
        Kirim Absen
    </button>
    <div class="text-xs text-gray-500 text-center">
        Status lokasi: <span id="locationStatus">Meminta izin...</span>
    </div>
</form>

<script>
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById('lat').value = pos.coords.latitude;
        document.getElementById('lng').value = pos.coords.longitude;
        document.getElementById('locationStatus').textContent = 'Lokasi berhasil didapatkan';
        document.getElementById('locationStatus').style.color = '#16a34a';
    }, function() {
        document.getElementById('locationStatus').textContent = 'Gagal mendapatkan lokasi';
        document.getElementById('locationStatus').style.color = '#dc2626';
    }, { enableHighAccuracy: true });
} else {
    document.getElementById('locationStatus').textContent = 'Geolocation tidak didukung';
    document.getElementById('locationStatus').style.color = '#dc2626';
}
</script>



