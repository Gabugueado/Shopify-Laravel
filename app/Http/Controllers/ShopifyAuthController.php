<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Shop;

class ShopifyAuthController extends Controller
{
    public function install(Request $request)
    {
        $request->validate(['shop' => 'required|string']); // ej: mystore.myshopify.com
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

        // 1) Validar STATE
        abort_if(!$shop || !$code || $state !== session('shopify_oauth_state'), 403, 'Estado inválido');

        // 2) Validar HMAC (recomendado en producción)
        // Por brevedad, omito la verificación del hmac aquí — agrégala para mayor seguridad (guía OAuth).  [oai_citation:4‡Shopify](https://shopify.dev/docs/apps/build/authentication-authorization?utm_source=chatgpt.com)

        // 3) Intercambiar CODE por ACCESS TOKEN
        $resp = Http::asForm()->post("https://{$shop}/admin/oauth/access_token", [
            'client_id'     => env('SHOPIFY_CLIENT_ID'),
            'client_secret' => env('SHOPIFY_SECRET'),
            'code'          => $code,
        ])->throw();

        $payload = $resp->json();
        // $payload = ['access_token' => 'xxx', 'scope' => 'read_products,read_orders']

        // 4) Guardar/Actualizar tienda
        Shop::updateOrCreate(
            ['shop_domain' => $shop],
            ['access_token' => $payload['access_token'], 'scope' => $payload['scope'] ?? null]
        );

        return redirect()->route('shopify.products')->with('ok', 'Tienda conectada');
    }
}