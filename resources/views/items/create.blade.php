<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pl-2">
            <i class="fa-solid fa-file-pen mr-1 text-blue-500"></i> Buat Laporan
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow p-6">

            @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-tag mr-1 text-blue-400"></i> Jenis Laporan
                    </label>
                    <select name="type" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>Barang Hilang</option>
                        <option value="found" {{ old('type') == 'found' ? 'selected' : '' }}>Barang Ditemukan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-box mr-1 text-orange-400"></i> Nama Barang
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Contoh: Dompet Hitam" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-list mr-1 text-purple-400"></i> Kategori
                    </label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Dompet">Dompet</option>
                        <option value="HP">HP</option>
                        <option value="Kunci">Kunci</option>
                        <option value="Tas">Tas</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Dokumen">Dokumen</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-align-left mr-1 text-gray-400"></i> Deskripsi
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Deskripsikan barang secara detail..." required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-location-dot mr-1 text-red-400"></i> Lokasi
                    </label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full border rounded-lg px-3 py-2"
                        placeholder="Contoh: Kantin Gedung A" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-regular fa-calendar mr-1 text-blue-400"></i> Tanggal
                    </label>
                    <input type="date" name="date" value="{{ old('date') }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-image mr-1 text-green-400"></i> Foto Barang (opsional)
                    </label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700">
                    <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>