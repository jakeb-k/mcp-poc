<?php
namespace App;

use PhpMcp\Server\Attributes\McpTool;

class ProductTools
{
    /**
     * Hit products API to return all products 
     *
     * @return array
     */
    #[McpTool(name: 'fetch_products')]
    public function fetchProducts(): array
    {
        file_put_contents('mcp_debug.log', 'Tool called at '.date('c')."\n", FILE_APPEND);
        $apiUrl = 'https://picklewear.test/api/v1/products'; // or whatever your local endpoint is

        $json = @file_get_contents($apiUrl);

        if ($json === false) {
            return ['error' => 'Failed to fetch products from API'];
        }

        $data = json_decode($json, true);

        return [
            'status' => 'success',
            'products' => $data,
        ];
    }
}