@extends('layouts.app')

@section('title', 'Products Shopify')

@section('content')
    <h2 class="text-xl font-bold mb-4">Products</h2>

   <a href="{{ route('shopify.export.excel') }}"
   class="inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition">
   Export Excel
</a>

<a href="{{ route('shopify.export.csv') }}"
   class="inline-block text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
   Export CSV
</a>
    @if (!empty($products['products']))
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
    @else
        <p>There's nothing to show.</p>
    @endif
@endsection
