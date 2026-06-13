<x-app-layout>
   <form method="GET" action="{{ route('items.index') }}" class="flex gap-2 mb-4 px-6 mt-6">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari barang..."
            class="w-64 border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <select name="category" class="border rounded-lg px-3 py-2 text-sm">
            <option value="">Semua Kategori</option>
            <option value="Dompet" {{ request('category') == 'Dompet' ? 'selected' : '' }}>Dompet</option>
            <option value="HP" {{ request('category') == 'HP' ? 'selected' : '' }}>HP</option>
            <option value="Kunci" {{ request('category') == 'Kunci' ? 'selected' : '' }}>Kunci</option>
            <option value="Tas" {{ request('category') == 'Tas' ? 'selected' : '' }}>Tas</option>
            <option value="Elektronik" {{ request('category') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
            <option value="Dokumen" {{ request('category') == 'Dokumen' ? 'selected' : '' }}>Dokumen</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fa-solid fa-magnifying-glass mr-1"></i> Cari
        </button>
    </form>

    <div class="py-6 px-6">

        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-2">
                <a href="?type=lost" class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Hilang
                </a>
                <a href="?type=found" class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fa-solid fa-circle-check mr-1"></i> Ditemukan
                </a>
                <a href="{{ route('items.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                    Semua
                </a>
            </div>
            <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-1"></i> Buat Laporan
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($items as $item)
            <div class="bg-white rounded-xl shadow p-4">
                @if($item->photo)
                <img src="{{ Storage::url($item->photo) }}" class="w-full h-40 object-cover rounded-lg mb-3">
                @else
                <div class="w-full h-40 bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                    <i class="fa-solid fa-{{ $item->type == 'lost' ? 'magnifying-glass' : 'box' }} text-gray-400 text-4xl"></i>
                </div>
                @endif

                <span class="text-xs px-2 py-1 rounded-full {{ $item->type == 'lost' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                    <i class="fa-solid fa-{{ $item->type == 'lost' ? 'circle-exclamation' : 'circle-check' }} mr-1"></i>
                    {{ $item->type == 'lost' ? 'Hilang' : 'Ditemukan' }}
                </span>

                <h2 class="font-bold text-lg mt-2">{{ $item->title }}</h2>
                <p class="text-gray-500 text-sm mt-1">
                    <i class="fa-solid fa-location-dot mr-1 text-red-400"></i> {{ $item->location }}
                </p>
                <p class="text-gray-500 text-sm">
                    <i class="fa-regular fa-calendar mr-1 text-blue-400"></i> {{ $item->date }}
                </p>
                <p class="text-gray-400 text-xs mt-1">
                    <i class="fa-solid fa-user mr-1"></i> {{ $item->user->name }}
                </p>

                <a href="{{ route('items.show', $item) }}"
                    class="mt-3 block text-center bg-gray-100 hover:bg-gray-200 py-2 rounded-lg text-sm font-medium">
                    Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 text-gray-400">
                <i class="fa-solid fa-box-open text-6xl mb-4 block"></i>
                <p class="text-lg">Belum ada laporan barang.</p>
                <a href="{{ route('items.create') }}" class="text-blue-500 hover:underline">Buat laporan pertama!</a>
            </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    </div>
</x-app-layout>