<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pl-2">
            <i class="fa-solid fa-users-gear mr-1 text-purple-500"></i> Kelola User
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.index') }}" class="text-blue-500 hover:underline text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">
                            <i class="fa-solid fa-user mr-1 text-gray-400"></i> {{ $user->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->is_banned)
                                <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-600">
                                    <i class="fa-solid fa-ban mr-1"></i> Banned
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_banned)
                                <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline text-xs font-medium">
                                        <i class="fa-solid fa-unlock mr-1"></i> Unban
                                    </button>
                                </form>
                            @else
                                <button onclick="document.getElementById('banModal{{ $user->id }}').classList.remove('hidden')"
                                        class="text-red-500 hover:underline text-xs font-medium">
                                    <i class="fa-solid fa-ban mr-1"></i> Ban
                                </button>

                                {{-- Modal Ban --}}
                                <div id="banModal{{ $user->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
                                    <div class="bg-white rounded-xl p-6 w-full max-w-sm shadow-lg">
                                        <h3 class="font-bold text-lg mb-3">
                                            <i class="fa-solid fa-triangle-exclamation text-red-500 mr-1"></i>
                                            Ban {{ $user->name }}?
                                        </h3>
                                        <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                                            @csrf
                                            <textarea name="ban_reason" rows="3" required
                                                class="w-full border rounded-lg px-3 py-2 mb-3 text-sm"
                                                placeholder="Alasan banned..."></textarea>
                                            <div class="flex gap-2">
                                                <button type="submit" class="flex-1 bg-red-500 text-white py-2 rounded-lg text-sm font-medium hover:bg-red-600">
                                                    <i class="fa-solid fa-ban mr-1"></i> Ban User
                                                </button>
                                                <button type="button"
                                                    onclick="document.getElementById('banModal{{ $user->id }}').classList.add('hidden')"
                                                    class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>