<?php
// Simple health check - no Laravel bootstrap
header('Content-Type: application/json');

$status = [
    'status' => 'ok',
    'php_version' => PHP_VERSION,
    'timestamp' => date('Y-m-d H:i:s'),
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
];

// Try to check if we can at least read files
$autoload = file_exists(__DIR__ . '/../vendor/autoload.php');
$status['autoload_exists'] = $autoload;

// Don't try to load Laravel - just report basics
echo json_encode($status, JSON_PRETTY_PRINT);
