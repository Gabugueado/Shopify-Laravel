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
        $v = env('SHOPIFY_API_VERSION', '2025-10');
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
        return $this->http()->get($this->baseUrl().'/products.json', $params)->throw()->json();
    }

    
    public function getOrdersLast30Days(): array
    {
        $createdAtMin = now()->subDays(30)->toIso8601String();
        
        $params = [
            'status' => 'any',
            'created_at_min' => $createdAtMin,
            'limit' => 50, 
            'fields' => 'id,created_at,total_price,financial_status,currency,customer,line_items'
        ];
        
        $res = $this->http()->get($this->baseUrl().'/orders.json', $params);
        
        if ($res->status() === 403) {
            return [
                'error' => true,
                'status' => 403,
                'message' => 'Shopify bloqueó el acceso a datos de cliente (Protected Customer Data). Usa campos limitados o revisa permisos.',
                'body' => $res->json(),
            ];
        }
        
        return $res->json();
    }
}