<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ShopifyAuthController extends Controller
{
    public function install(Request $request)
    {
        $request->validate(['shop' => 'required|string']);
        $shop = $request->query('shop');
        $state = Str::random(32);
        session(['shopify_oauth_state' => $state]);

        $query = http_build_query([
            'client_id'    => env('SHOPIFY_CLIENT_ID'),
            'scope'        => env('SHOPIFY_SCOPES'),
            'redirect_uri' => env('SHOPIFY_REDIRECT_URI'),
            'state'        => $state,
        ]);
        return redirect("https://{$shop}/admin/oauth/authorize?{$query}");

    }

    public function callback(Request $request)
    {
        $shop  = $request->query('shop');
        $code  = $request->query('code');
        $state = $request->query('state');

        abort_if(!$shop || !$code || $state !== session('shopify_oauth_state'), 403, 'Estado inválido');

        $resp = Http::asForm()->post("https://{$shop}/admin/oauth/access_token", [
            'client_id'     => env('SHOPIFY_CLIENT_ID'),
            'client_secret' => env('SHOPIFY_SECRET'),
            'code'          => $code,
        ])->throw();

        $payload = $resp->json();

        $shop = Shop::updateOrCreate(
            ['shop_domain' => $shop],
            [
                'access_token' => $payload['access_token'],
                'scope' => $payload['scope'] ?? null,
                'user_id' => Auth::id(),
            ]
        );
        return redirect()
                ->route('shopify.products', ['shop' => $shop->id])
                ->with('ok', 'Store connected');
    }
}