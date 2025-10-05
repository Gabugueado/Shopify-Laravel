@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-white">Welcome, {{ auth()->user()->name ?? 'Invitado' }}</h1>
    @if (!$haveProducts && auth()->user()->name === null )
    <div class="space-y-4">
        <a href="{{ route('shopify.install') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Conect to Shopify
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products['products'] as $product)
            <div class="bg-white border rounded-lg shadow p-4 hover:shadow-md">
                @if (!empty($product['image']))
                    <img src="{{ $product['image']['src'] }}" class="w-full h-48 object-cover rounded mb-3" />
                @endif
                <h3 class="font-semibold text-gray-800">{{ $product['title'] }}</h3>
                <p class="text-gray-600 text-sm">
                    {{ $product['variants'][0]['price'] ?? '—' }} {{ $product['variants'][0]['currency'] ?? '' }}
                </p>
                <span>sku: {{ $product['variants'][0]['sku'] ?? '-' }}</span>
            </div>
        @endforeach
    </div>
    @endif
@endsection