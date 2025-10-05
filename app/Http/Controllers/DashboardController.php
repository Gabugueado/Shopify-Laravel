<?php

namespace App\Http\Controllers;

use App\Services\ShopifyClient;
use App\Models\Shop;

class DashboardController extends Controller
{
    public function dashboard() {
        $shopDomain = Shop::value('shop_domain');
        $client = ShopifyClient::for($shopDomain);
        $products = $client->getProducts(['limit' => 50]);

        $haveProducts = !empty($products['products']);
        
        return view('dashboard', compact('haveProducts', 'products'));
    }
}