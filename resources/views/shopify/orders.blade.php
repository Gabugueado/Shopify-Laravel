
@extends('layouts.app')

@section('title', 'orders shopify')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Last Orders 30 days</h1>

    @php
        $items = $orders['orders'] ?? [];
    @endphp

    @if (empty($items))
        <p>There's nothing to show</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-left">Products</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Currency</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($items as $order)
                        @php
                            $cliente = trim(($order['customer']['first_name'] ?? 'Sin cliente') . ' ' . ($order['customer']['last_name'] ?? ''));
                            $productos = collect($order['line_items'] ?? [])->pluck('title')->join(', ');
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-900 font-medium">#{{ $order['id'] }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $cliente }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $productos ?: '—' }}</td>
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
                                    {{ ucfirst($order['financial_status'] ?? '—') }}
                                </span>
                            </td>
                                                        <td class="px-4 py-3 font-semibold text-gray-900">${{ $order['total_price'] ?? '0.00' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $order['currency'] ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection