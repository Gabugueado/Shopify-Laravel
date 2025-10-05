<?php

namespace App\Services;

use App\Models\Shop;
use Illuminate\Support\Facades\Http;

class ShopifyClient
{
    public function __construct(private Shop $shop) {}

    public static function for(string $shopDomain): self
    {
        $shop = Shop::where('shop_domain', $shopDomain)->firstOrFail();
        return new self($shop);
    }

    private function baseUrl(): string
    {
        $v = env('SHOPIFY_API_VERSION', '2025-10'); // versión estable actual.  [oai_citation:5‡Shopify](https://shopify.dev/docs/api/admin-rest?utm_source=chatgpt.com)
        return "https://{$this->shop->shop_domain}/admin/api/{$v}";
    }

    private function http()
    {
        return Http::withHeaders([
            'X-Shopify-Access-Token' => $this->shop->access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }

    // Productos
    public function getProducts(array $params = [])
    {
        // Ej: GET /products.json
        return $this->http()->get($this->baseUrl().'/products.json', $params)->throw()->json();
        // Referencia REST products.  [oai_citation:6‡Shopify](https://shopify.dev/docs/api/admin-rest?utm_source=chatgpt.com)
    }

    // Pedidos últimos 30 días
    public function getOrdersLast30Days(): array
    {
        $createdAtMin = now()->subDays(30)->toIso8601String();
        // Filtro por created_at_min con REST Orders
        $params = [
            'status' => 'any',
            'created_at_min' => $createdAtMin,
            'limit' => 50, 
            'fields' => 'id,created_at,total_price,financial_status,currency'
        ];
        
        $res = $this->http()->get($this->baseUrl().'/orders.json', $params);
        // Si da 403, devolvemos un arreglo vacío o el mensaje de error para debugging
        if ($res->status() === 403) {
            return [
                'error' => true,
                'status' => 403,
                'message' => 'Shopify bloqueó el acceso a datos de cliente (Protected Customer Data). Usa campos limitados o revisa permisos.',
                'body' => $res->json(),
            ];
        }
        // Endpoint Orders y filtros de fecha están en la referencia REST.  [oai_citation:7‡Shopify](https://shopify.dev/docs/api/admin-rest/latest/resources/order?utm_source=chatgpt.com)
        return $res->json();
    }
}