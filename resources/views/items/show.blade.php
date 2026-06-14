<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pl-2">
            <i class="fa-solid fa-magnifying-glass mr-1 text-blue-500"></i> Detail Laporan
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6 mb-6">
            @if($item->photo)
            <img src="{{ Storage::url($item->photo) }}" class="w-full h-60 object-cover rounded-lg mb-4">
            @endif

            <div class="flex items-center gap-2 mb-3">
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $item->type == 'lost' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                    <i class="fa-solid fa-{{ $item->type == 'lost' ? 'circle-exclamation' : 'circle-check' }} mr-1"></i>
                    {{ $item->type == 'lost' ? 'Hilang' : 'Ditemukan' }}
                </span>
                <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                    <i class="fa-solid fa-{{ $item->status == 'open' ? 'clock' : 'circle-check' }} mr-1"></i>
                    {{ $item->status == 'open' ? 'Masih Dicari' : 'Sudah Matched' }}
                </span>
            </div>

            <h1 class="text-2xl font-bold mb-2">{{ $item->title }}</h1>
            <p class="text-gray-600 mb-4">{{ $item->description }}</p>

            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                <p>
                    <i class="fa-solid fa-box mr-1 text-orange-400"></i> Kategori:
                    <span class="font-medium text-gray-700">{{ $item->category }}</span>
                </p>
                <p>
                    <i class="fa-solid fa-location-dot mr-1 text-red-400"></i> Lokasi:
                    <span class="font-medium text-gray-700">{{ $item->location }}</span>
                </p>
                <p>
                    <i class="fa-regular fa-calendar mr-1 text-blue-400"></i> Tanggal:
                    <span class="font-medium text-gray-700">{{ $item->date }}</span>
                </p>
                <p>
                    <i class="fa-solid fa-user mr-1 text-gray-400"></i> Pelapor:
                    <span class="font-medium text-gray-700">{{ $item->user->name }}</span>
                </p>
            </div>

            @if(auth()->id() == $item->user_id)
            <div class="mt-4 pt-4 border-t">
                <a href="{{ route('items.edit', $item) }}" class="text-yellow-500 hover:underline text-sm inline-block">
                    <i class="fa-solid fa-pen mr-1"></i> Edit Laporan
                </a>
                <form action="{{ route('items.destroy', $item) }}" method="POST" class="mt-2"
                    onsubmit="return confirm('Yakin hapus laporan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline text-sm">
                        <i class="fa-solid fa-trash mr-1"></i> Hapus Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Form Klaim: hanya untuk laporan DITEMUKAN --}}
        @if(auth()->id() != $item->user_id && $item->status == 'open' && $item->type == 'found')
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-3">
                <i class="fa-solid fa-paper-plane mr-1 text-blue-500"></i> Klaim Ini Barang Saya!
            </h3>
            <form action="{{ route('claims.store', $item) }}" method="POST">
                @csrf
                <textarea name="message" rows="3" required
                    class="w-full border rounded-lg px-3 py-2 mb-3"
                    placeholder=""></textarea>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Klaim
                </button>
            </form>
        </div>
        @endif

        {{-- Form Info: hanya untuk laporan HILANG --}}
        @if(auth()->id() != $item->user_id && $item->status == 'open' && $item->type == 'lost')
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-3">
                <i class="fa-solid fa-lightbulb mr-1 text-yellow-500"></i> Kasih Info Temuan
            </h3>
            <form action="{{ route('claims.store', $item) }}" method="POST">
                @csrf
                <textarea name="message" rows="3" required
                    class="w-full border rounded-lg px-3 py-2 mb-3"
                    placeholder=""></textarea>
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    <i class="fa-solid fa-lightbulb mr-1"></i> Kirim Info
                </button>
            </form>
        </div>
        @endif

        {{-- Daftar Klaim/Info (hanya pemilik yang lihat) --}}
        @if(auth()->id() == $item->user_id && $claims->count() > 0)
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-bold text-lg mb-4">
                <i class="fa-solid fa-inbox mr-1 text-blue-500"></i>
                {{ $item->type == 'found' ? 'Daftar Klaim' : 'Daftar Info Temuan' }}
                ({{ $claims->count() }})
            </h3>
            @foreach($claims as $claim)
            <div class="border rounded-lg p-4 mb-3">
                <p class="font-medium">
                    <i class="fa-solid fa-user mr-1 text-gray-400"></i> {{ $claim->user->name }}
                </p>
                <p class="text-gray-600 text-sm mt-1">{{ $claim->message }}</p>
                <p class="text-xs mt-2">
                    Status:
                    <span class="{{ $claim->status == 'approved' ? 'text-green-600' : ($claim->status == 'rejected' ? 'text-red-500' : 'text-yellow-500') }} font-medium">
                        <i class="fa-solid fa-{{ $claim->status == 'approved' ? 'circle-check' : ($claim->status == 'rejected' ? 'circle-xmark' : 'clock') }} mr-1"></i>
                        {{ ucfirst($claim->status) }}
                    </span>
                </p>
                @if($claim->status == 'pending')
                <div class="flex gap-2 mt-3">
                    <form action="{{ route('claims.approve', $claim) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                            <i class="fa-solid fa-check mr-1"></i>
                            {{ $item->type == 'found' ? 'Setuju, Ini Barang Saya' : 'Info Berguna!' }}
                        </button>
                    </form>
                    <form action="{{ route('claims.reject', $claim) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                            <i class="fa-solid fa-xmark mr-1"></i> Tolak
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('items.index') }}" class="text-blue-500 hover:underline">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke daftar
            </a>
        </div>
    </div>
</x-app-layout>