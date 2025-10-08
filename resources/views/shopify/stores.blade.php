@extends('layouts.app')

@section('title', 'Your Shopify\'s stores')

@section('content')

<form action="{{ route('shopify.install') }}" method="GET" target="_blank" class="flex gap-2 items-center">
    <div>
        <input type="text" id="shop" name="shop" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-5 py-2.5 me-6 mb-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="store-name.myshopify.com" required />
    </div>
    <button 
        class="inline-block text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition">
        Connect new store
    </button>
</form>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    shop domain
                </th>
                <th scope="col" class="px-6 py-3">
                    scope
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ( $stores as $store)
            @php
            @endphp
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $store->shop_domain }}
                </th>
                <td class="px-6 py-4">
                    {{ $store->scope }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('shopify.products',  [ 'shop' => $store->id ]) }}"class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Products</a>
                    <a href="{{ route('shopify.orders30d', [ 'shop' => $store->id ]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Orders</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection