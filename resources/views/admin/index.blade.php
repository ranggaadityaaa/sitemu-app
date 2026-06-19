<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👑 Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        {{-- Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-500 text-white rounded-xl p-4 text-center shadow">
                <p class="text-3xl font-bold">{{ $totalItems }}</p>
                <p class="text-sm mt-1">Total Laporan</p>
            </div>
            <div class="bg-green-500 text-white rounded-xl p-4 text-center shadow">
                <p class="text-3xl font-bold">{{ $totalMatched }}</p>
                <p class="text-sm mt-1">Berhasil Matched</p>
            </div>
            <div class="bg-yellow-500 text-white rounded-xl p-4 text-center shadow">
                <p class="text-3xl font-bold">{{ $totalClaims }}</p>
                <p class="text-sm mt-1">Total Klaim</p>
            </div>
            <div class="bg-purple-500 text-white rounded-xl p-4 text-center shadow">
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                <p class="text-sm mt-1">Total User</p>
            </div>
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.users') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700">
                    <i class="fa-solid fa-users mr-1"></i> Kelola User
                </a>
            </div>
        </div>

        {{-- Tabel Semua Laporan --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Barang</th>
                        <th class="px-4 py-3 text-left">Pelapor</th>
                        <th class="px-4 py-3 text-left">Tipe</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $item->title }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->user->name }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $item->type == 'lost' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                {{ $item->type == 'lost' ? '🔴 Hilang' : '🟢 Ditemukan' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.items.delete', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $items->links() }}</div>
        </div>
    </div>
</x-app-layout>