<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromArray, WithHeadings
{
    protected $products;

    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function array(): array
    {
        return collect($this->products['products'] ?? [])->map(function ($product) {
            $variant = $product['variants'][0] ?? [];
            return [
                'ID' => $product['id'],
                'Título' => $product['title'],
                'Precio' => $variant['price'] ?? '-',
                'SKU' => $variant['sku'] ?? '-',
                'Tipo' => $product['product_type'] ?? '-',
                'Estado' => $product['status'] ?? '-',
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return ['ID', 'Título', 'Precio', 'SKU', 'Tipo', 'Estado'];
    }
}