<?php

namespace App\Http\Controllers;

use App\Services\ShopifyClient;
use App\Models\Shop;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Http\Controllers\response;

class ShopifyDataController extends Controller
{
    // Puedes fijar una tienda de pruebas (en duro) mientras conectas UI
    private function shopDomain(): string {
        // Reemplaza con la que conectaste vía OAuth (o guárdala en sesión)
        return Shop::query()->value('shop_domain');
    }

    public function products()
    {
        $client = ShopifyClient::for($this->shopDomain());
        $products = $client->getProducts(['limit' => 50]);
        // return response()->json($data);
        return view('shopify.products', compact('products'));
    }
    
    
    public function ordersLast30Days()
    {
        $client = ShopifyClient::for($this->shopDomain());
        $orders = $client->getOrdersLast30Days();
        // return response()->json($data);
        return view('shopify.orders', compact('orders'));
    }
    public function exportExcel()
    {
        $data = $this->getProductsData(); // Reutilizas tu método actual
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