@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Kategori Produk</h1>
    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $category)
    <div class="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
        <div class="h-48 bg-gray-200">
            @if($category->foto_produk)
                <img src="{{ asset('storage/' . $category->foto_produk) }}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
            @endif
        </div>
        <div class="p-5">
            <h3 class="font-bold text-lg text-gray-800">{{ $category->nama_kategori }}</h3>
            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $category->deskripsi }}</p>
            
            <div class="mt-4 flex gap-2">
                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 text-sm font-medium hover:underline">Edit</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm font-medium hover:underline">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection