<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Catalog | Premium UMKM</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Alpine.js (Untuk Interaksi Mobile Menu) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex relative">
        
        <!-- Backdrop untuk Mobile (Muncul saat sidebar terbuka di HP) -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden" x-cloak></div>

        <!-- Sidebar Modern (Responsif) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 left-0 w-72 bg-slate-900 text-white flex-shrink-0 flex flex-col shadow-2xl z-50 transition-transform duration-300 ease-in-out">
            
            <div class="p-8">
                <div class="flex items-center justify-between mb-10">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-500 p-2 rounded-xl shadow-lg shadow-indigo-500/20">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight">Smart<span class="text-indigo-400">Catalog</span></span>
                    </div>
                    <!-- Tombol Tutup (Hanya di Mobile) -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <nav class="space-y-1.5">
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-4 ml-4">Menu Utama</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="tags" class="w-5 h-5"></i>
                        <span class="font-medium">Kategori Produk</span>
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-8 border-t border-slate-800">
                <div class="flex items-center gap-3 p-3 bg-slate-800/50 rounded-2xl border border-slate-700/50">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white shadow-inner">
                        {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 bg-green-500 border-2 border-slate-900 w-4 h-4 rounded-full flex items-center justify-center">
                            <i data-lucide="check" class="w-2 h-2 text-white font-bold"></i>
                        </div>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-tight">Merchant</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
            <!-- Navbar Modern -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-6 lg:px-10 z-30">
                <div class="flex items-center gap-4">
                    <!-- Tombol Hamburger (Hanya muncul di Mobile) -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div class="hidden sm:block">
                        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Panel Merchant</h2>
                        <p class="text-sm text-slate-600 font-medium">Smart-Catalog UMKM</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 lg:gap-6">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-red-500 transition-colors bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <i data-lucide="log-out" class="w-4 h-4 text-red-400"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Isi Konten Dinamis -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-10">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Inisialisasi Ikon Lucide
        lucide.createIcons();
    </script>
</body>
</html>