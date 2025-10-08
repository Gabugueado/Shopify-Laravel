<?php

namespace App\Http\Controllers;

use App\Services\ShopifyClient;
use App\Models\Shop;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Illuminate\Support\Facades\Auth;

class ShopifyDataController extends Controller
{
    public function products($shopId)
    {
        $client = ShopifyClient::fromShopId($shopId);
        $products = $client->getProducts(['limit' => 50]);
        return view('shopify.products', compact('products'));
    }
    
    public function ordersLast30Days($shopId)
    {
        $client = ShopifyClient::fromShopId($shopId);
        $orders = $client->getOrdersLast30Days();
        return view('shopify.orders', compact('orders'));
    }

    public function exportExcel($shopId)
    {
        $client = ShopifyClient::fromShopId($shopId);
        $data = $client->getProducts();
        return Excel::download(new ProductsExport($data), 'productos.xlsx');
    }

    public function exportCsv($shopId)
    {
        $client = ShopifyClient::fromShopId($shopId);
        $data = $client->getProducts();
        return Excel::download(new ProductsExport($data), 'productos.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function stores ()
    {
        $stores = Shop::where('user_id', Auth::id())->get();
        return view('shopify.stores', compact('stores'));
    }
}   