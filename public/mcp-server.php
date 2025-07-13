#!/usr/bin/env php
<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . '/../src/ProductTools.php';
require_once __DIR__ . '/../src/CalculatorElements.php';

use App\ProductTools;
use App\CalculatorElements;
use PhpMcp\Server\Server;
use PhpMcp\Server\Transports\StreamableHttpServerTransport;

try {
    $server = Server::make()
    ->withServerInfo('Picklewear MCP Server', '0.1.0')
    ->build();

    // Instantiate the tool classes so they can be discovered
    $productTools = new ProductTools();
    $calculatorTools = new CalculatorElements();

    echo "🔍 Discovering tools...\n";
    
    $server->discover(
    basePath: __DIR__.'/..',
    scanDirs: ['src']
    );

    $registry = $server->getRegistry();
    $tools = $registry->getTools();
    $toolCount = count($tools);
    echo "📋 Found " . $toolCount . " tools in registry\n";
    
    if (empty($tools)) {
        echo "⚠️  WARNING: No tools discovered! Check your #[McpTool] attributes.\n";
    } else {
        echo "✅ Tools discovered:\n";
        foreach ($tools as $name => $tool) {
            echo "   - $name\n";
        }
    }

    // Create streamable transport with resumability
    $transport = new StreamableHttpServerTransport(
        host: '127.0.0.1',      // MCP protocol prohibits 0.0.0.0
        port: 5001,
        mcpPath: 'mcp',
        enableJsonResponse: true,   // Enable JSON response for HTTP compatibility
    );

    echo "🚀 MCP Server is running on http://127.0.0.1:5001\n";

    file_put_contents('discovered_tools.log', json_encode($registry, JSON_PRETTY_PRINT));

    $server->listen($transport);

} catch (\Throwable $e) {
    fwrite(STDERR, "[CRITICAL ERROR] " . $e->getMessage() . "\n");
    exit(1);
}
