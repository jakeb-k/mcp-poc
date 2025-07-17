<?php
namespace App;

use PhpMcp\Server\Attributes\McpTool;
use PhpMcp\Server\Attributes\Schema;

class ProductTools
{
    /**
     * Hit products API to return (some) products 
     *
     * @return array
     */
    #[McpTool(name: 'fetch_products')]
    public function fetchProducts(): array
    {
        $timestamp = date('c');
        $apiUrl = 'https://picklewear.test/api/v1/products';
    
        try {
            $client = new HttpRequest();
            $response = $client->get($apiUrl);
    
            return [
                'status' => 'success',
                'products' => $response['data'],
            ];
        } catch (\Exception $e) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$e->getCode()}): {$e->getMessage()}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return ['error' => 'Failed to fetch products from API'];
        }
    }

    /**
     * Create a product
     *
     * Accepts product data and sends it to the API.
     * Validates structure before making the request.
     */
    #[McpTool(name: 'create_product')]
    #[Schema(
        type: 'object',
        properties: [
            'name' => [
                'type' => 'string',
                'minLength' => 1,
                'maxLength' => 100,
                'description' => 'The name of the product (1–100 chars)'
            ],
            'price' => [
                'type' => 'number',
                'minimum' => 0,
                'description' => 'The price of the product (must be >= 0)'
            ],
            'description' => [
                'type' => 'string',
                'description' => 'Detailed product description'
            ]
        ],
        required: ['name', 'price', 'description']
    )]
    public function createProduct(string $name, float $price, string $description): array
    {
        $timestamp = date('c');
        $apiUrl =  'https://picklewear.test/api/v1/product/store'; 
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description
        ];
        try {
            $client = new HttpRequest();
            $response = $client->post($apiUrl, $data);
    
            return [
                'message' => 'Successfully created product',
                'product' => $response['data'],
            ];
        } catch (\Exception $e) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$e->getCode()}): {$e->getMessage()}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return ['error' => 'Failed to fetch products from API'];
        }
    }

    /**
     * Update a product
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    #[McpTool(name: 'update_product')]
    #[Schema(
        type: 'object',
        properties: [
            'id' => [
                'type' => 'integer',
                'description' => 'The ID of the product to update'
            ],
            'name' => [
                'type' => 'string',
                'minLength' => 1,
                'maxLength' => 100,
                'description' => 'The name of the product (1–100 chars)'
            ],
            'price' => [
                'type' => 'number',
                'minimum' => 0,
                'description' => 'The price of the product (must be >= 0)'
            ],
            'description' => [
                'type' => 'string',
                'description' => 'Detailed product description'
            ]
        ],
        required: ['id', 'name', 'price', 'description']
    )]
    public function updateProduct(int $id, string $name, float $price, string $description): array
    {
        $timestamp = date('c');
        $apiUrl = 'https://picklewear.test/api/v1/product/'.$id.'/update';
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description
        ];
        try {
            $client = new HttpRequest();
            $response = $client->put($apiUrl, $data);
    
            return [
                'message' => 'Successfully updated product',
                'product' => $response['data'],
            ];
        } catch (\Exception $e) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$e->getCode()}): {$e->getMessage()}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return ['error' => 'Failed to fetch products from API'];
        }
    }
    
}