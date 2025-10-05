
@extends('layouts.app')

@section('title', 'ordenes shopify')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Órdenes recientes</h1>

    @php
        $items = $orders['orders'] ?? [];
    @endphp

    @if (empty($items))
        <p>No se encontraron órdenes recientes.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Moneda</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($items as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900 font-medium">#{{ $order['id'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $order['created_at'] }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if ($order['financial_status'] === 'paid')
                                        bg-green-100 text-green-700
                                    @elseif ($order['financial_status'] === 'pending')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ ucfirst($order['financial_status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900">${{ $order['total_price'] }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $order['currency'] ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection