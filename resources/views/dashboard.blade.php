@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
    <!-- Pesan Dinamis Berdasarkan Session User -->
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
    <p class="text-gray-500">Aplikasi Smart-Catalog UMKM siap membantu Anda mengelola data kategori produk.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
            <h3 class="font-bold text-blue-800">Cepat & Efisien</h3>
            <p class="text-sm text-blue-600 mt-1">Kelola ribuan kategori dalam hitungan detik dengan sistem MVC Laravel.</p>
        </div>
        <div class="bg-green-50 p-6 rounded-lg border border-green-100">
            <h3 class="font-bold text-green-800">Keamanan Terjamin</h3>
            <p class="text-sm text-green-600 mt-1">Implementasi Allowed Fields melindungi data Anda dari Mass Assignment.</p>
        </div>
    </div>
</div>
@endsection