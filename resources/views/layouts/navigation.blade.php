<nav class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg">
    <div class="w-full px-6">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('items.index') }}" class="flex items-center gap-2">
                    <img src="{{ asset('sitemu.png') }}" class="w-10 h-10 rounded-full" alt="logo">
                    <span class="text-white font-bold text-xl tracking-wide">SiTemu</span>
                </a>
            </div>

            {{-- Menu Tengah --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('items.index') }}"
                    class="text-blue-100 hover:text-white text-sm font-medium transition">
                    <i class="fa-solid fa-house mr-1"></i> Beranda
                </a>
                <a href="{{ route('items.index') }}?type=lost"
                    class="text-blue-100 hover:text-white text-sm font-medium transition">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Barang Hilang
                </a>
                <a href="{{ route('items.index') }}?type=found"
                    class="text-blue-100 hover:text-white text-sm font-medium transition">
                    <i class="fa-solid fa-circle-check mr-1"></i> Barang Ditemukan
                </a>
                <a href="{{ route('items.create') }}"
                    class="bg-white text-blue-600 px-4 py-2 rounded-full text-sm font-semibold hover:bg-blue-50 transition shadow">
                    <i class="fa-solid fa-plus mr-1"></i> Buat Laporan
                </a>
            </div>

            {{-- Notification Bell --}}
            <div class="relative">
                <button class="text-white p-2 hover:bg-white/20 rounded-full transition relative">
                    <i class="fa-solid fa-bell"></i>
                    <span id="notif-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">!</span>
                </button>
            </div>

            {{-- User Dropdown --}}
            <div class="flex items-center gap-3">
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.index') }}"
                    class="bg-yellow-400 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-yellow-500 transition shadow">
                    Admin
                </a>
                @endif
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-full transition">
                        <i class="fa-solid fa-user"></i>
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50">
                        <div class="px-4 py-2 border-b">
                            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @auth
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.Echo) {
        window.Echo.private('notifications.{{ auth()->id() }}')
            .listen('.NewClaimNotification', (e) => {
                const badge = document.getElementById('notif-badge');
                if (badge) badge.classList.remove('hidden');

                const toast = document.createElement('div');
                toast.className = 'fixed top-20 right-4 bg-white shadow-lg rounded-lg p-4 max-w-sm z-50 border-l-4 border-blue-500';
                toast.innerHTML = `
                    <p class="text-sm font-medium text-gray-800">${e.message}</p>
                    <a href="/items/${e.item_id}" class="text-blue-500 text-xs hover:underline">Lihat detail →</a>
                `;
                document.body.appendChild(toast);

                setTimeout(() => toast.remove(), 5000);
            });
    }
});
</script>
@endauth
</nav>