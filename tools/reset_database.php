<?php

declare(strict_types=1);

/**
 * Dev-only helper to drop + recreate the configured MySQL database.
 *
 * Usage:
 *   php tools/reset_database.php
 */

function readEnvFile(string $path): array
{
    if (!is_file($path)) {
        return [];
    }

    $vars = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return [];
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }

        $key = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));

        if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
            $quote = $value[0];
            if (str_ends_with($value, $quote)) {
                $value = substr($value, 1, -1);
            }
        }

        $vars[$key] = $value;
    }

    return $vars;
}

$root = dirname(__DIR__);
$env = readEnvFile($root . DIRECTORY_SEPARATOR . '.env');

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = (int)($env['DB_PORT'] ?? 3306);
$dbName = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? 'root';
$pass = $env['DB_PASSWORD'] ?? '';

if ($dbName === '') {
    fwrite(STDERR, "DB_DATABASE is empty in .env\n");
    exit(2);
}

$dsn = "mysql:host={$host};port={$port};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $quotedDb = '`' . str_replace('`', '``', $dbName) . '`';

    echo "Dropping database {$dbName} (if it exists)...\n";
    $pdo->exec("DROP DATABASE IF EXISTS {$quotedDb}");

    echo "Creating database {$dbName}...\n";
    $pdo->exec("CREATE DATABASE {$quotedDb} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    echo "OK\n";
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}
