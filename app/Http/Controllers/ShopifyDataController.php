<?php

namespace App\Http\Controllers;

use App\Services\ShopifyClient;
use App\Models\Shop;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

class ShopifyDataController extends Controller
{
    private function shopDomain(): string {
        return Shop::query()->value('shop_domain');
    }

    public function products()
    {
        $client = ShopifyClient::for($this->shopDomain());
        $products = $client->getProducts(['limit' => 50]);
        return view('shopify.products', compact('products'));
    }
    
    
    public function ordersLast30Days()
    {
        $client = ShopifyClient::for($this->shopDomain());
        $orders = $client->getOrdersLast30Days();
        return view('shopify.orders', compact('orders'));
    }
    public function exportExcel()
    {
        $data = $this->getProductsData();
        return Excel::download(new ProductsExport($data), 'productos.xlsx');
    }

    public function exportCsv()
    {
        $data = $this->getProductsData();
        return Excel::download(new ProductsExport($data), 'productos.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    private function getProductsData(): array 
    {
        $client = ShopifyClient::for($this->shopDomain());
        $products = $client->getProducts();
        return $products; 
    }
}