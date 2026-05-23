@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Katalog Produk</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Manajemen daftar semua produk fisik UMKM Anda</p>
        </div>
        <a href="{{ route('products.create') }}" class="group bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20">
            <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
            Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm animate-pulse">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="group bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
            <div class="relative h-60 bg-slate-100 overflow-hidden">
                @if($product->foto_produk)
                    <img src="{{ asset('storage/' . $product->foto_produk) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="flex flex-col items-center justify-center h-full text-slate-300 gap-2">
                        <i data-lucide="image" class="w-10 h-10 opacity-20"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">No Image Asset</span>
                    </div>
                @endif
                <!-- Overlay Action -->
                <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 backdrop-blur-sm">
                    <a href="{{ route('products.edit', $product->id) }}" class="p-3 bg-white text-indigo-600 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all shadow-xl">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-3 bg-white text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-xl">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="p-8">
                <div class="flex items-center gap-2 mb-3">
                    <!-- Relasi Dipanggil di Sini ($product->category->nama_kategori) -->
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg tracking-wider">
                        {{ $product->category->nama_kategori }}
                    </span>
                    <span class="text-slate-300 text-[10px] font-bold tracking-widest italic">{{ $product->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $product->nama_produk }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-4 font-medium">{{ $product->deskripsi }}</p>
                
                <div class="pt-4 border-t border-slate-50 flex items-center justify-between text-slate-700">
                    <span class="text-lg font-black text-indigo-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-2 transition-transform text-indigo-500"></i>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-400 bg-white rounded-[2rem] border-2 border-dashed border-slate-200">
            <div class="bg-slate-50 p-6 rounded-full mb-4">
                <i data-lucide="folder-open" class="w-12 h-12 opacity-20"></i>
            </div>
            <p class="font-bold text-slate-500">Belum ada produk apapun</p>
            <p class="text-xs mt-1 font-medium">Hubungkan produk Anda dengan memilih kategori yang sudah dibuat.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection