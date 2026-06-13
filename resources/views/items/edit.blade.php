<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pl-2">
            <i class="fa-solid fa-pen-to-square mr-1 text-yellow-500"></i> Edit Laporan
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

            <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-tag mr-1 text-blue-400"></i> Jenis Laporan
                    </label>
                    <select name="type" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="lost" {{ $item->type == 'lost' ? 'selected' : '' }}>Barang Hilang</option>
                        <option value="found" {{ $item->type == 'found' ? 'selected' : '' }}>Barang Ditemukan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-box mr-1 text-orange-400"></i> Nama Barang
                    </label>
                    <input type="text" name="title" value="{{ $item->title }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-list mr-1 text-purple-400"></i> Kategori
                    </label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="Dompet" {{ $item->category == 'Dompet' ? 'selected' : '' }}>Dompet</option>
                        <option value="HP" {{ $item->category == 'HP' ? 'selected' : '' }}>HP</option>
                        <option value="Kunci" {{ $item->category == 'Kunci' ? 'selected' : '' }}>Kunci</option>
                        <option value="Tas" {{ $item->category == 'Tas' ? 'selected' : '' }}>Tas</option>
                        <option value="Elektronik" {{ $item->category == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Dokumen" {{ $item->category == 'Dokumen' ? 'selected' : '' }}>Dokumen</option>
                        <option value="Lainnya" {{ $item->category == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-align-left mr-1 text-gray-400"></i> Deskripsi
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full border rounded-lg px-3 py-2" required>{{ $item->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-location-dot mr-1 text-red-400"></i> Lokasi
                    </label>
                    <input type="text" name="location" value="{{ $item->location }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-regular fa-calendar mr-1 text-blue-400"></i> Tanggal
                    </label>
                    <input type="date" name="date" value="{{ $item->date }}"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fa-solid fa-image mr-1 text-green-400"></i> Foto Baru (opsional)
                    </label>
                    @if($item->photo)
                    <img src="{{ Storage::url($item->photo) }}" class="w-32 h-32 object-cover rounded-lg mb-2">
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="w-full border rounded-lg px-3 py-2">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('items.show', $item) }}"
                        class="flex-1 text-center bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200">
                        <i class="fa-solid fa-xmark mr-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>