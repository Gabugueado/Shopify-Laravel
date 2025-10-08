<?php

namespace App\Http\Controllers;

use App\Services\ShopifyClient;
use App\Models\Shop;

class DashboardController extends Controller
{
    public function dashboard() {        
        return view('dashboard');
    }
}