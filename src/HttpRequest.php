<?php
namespace App;

class HttpRequest
{
    public static function get(string $url): array
    {
        $timestamp = date('c');
        $ch = curl_init($url);
    
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FAILONERROR => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
            ],
        ]);
    
        $body = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        curl_close($ch);
    
        if ($body === false) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$httpCode}): {$error}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Failed to fetch from API',
                'http_code' => $httpCode,
            ];
        }
    
        $data = json_decode($body, true);
    
        if ($data === null) {
            $logMsg = "[$timestamp] JSON decode failed: $body";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Invalid JSON response from API',
                'raw_response' => $body,
            ];
        }
    
        return [
            'data' => $data,
            'status' => $httpCode,
        ];
    }

    public static function post(string $url, array $data): array
    {
        
        $timestamp = date('c');
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FAILONERROR => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $body = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($body === false) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$httpCode}): {$error}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Failed to fetch from API',
                'http_code' => $httpCode,
            ];
        }
    
        $data = json_decode($body, true);
    
        if ($data === null) {
            $logMsg = "[$timestamp] JSON decode failed: $body";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Invalid JSON response from API',
                'raw_response' => $body,
            ];
        }
    
        return [
            'data' => $data,
            'status' => $httpCode,
        ];
    }

    public static function put(string $url, array $data): array
    {
        
        $timestamp = date('c');
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FAILONERROR => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);
    

        $body = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($body === false) {
            $logMsg = "[$timestamp] cURL failed: Unable to get response from API ({$httpCode}): {$error}";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Failed to fetch from API',
                'http_code' => $httpCode,
            ];
        }
    
        $data = json_decode($body, true);
    
        if ($data === null) {
            $logMsg = "[$timestamp] JSON decode failed: $body";
            file_put_contents('mcp_debug.log', $logMsg . "\n", FILE_APPEND);
            return [
                'error' => 'Invalid JSON response from API',
                'raw_response' => $body,
            ];
        }
    
        return [
            'data' => $data,
            'status' => $httpCode,
        ];
    }

}