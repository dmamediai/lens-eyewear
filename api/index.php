<?php

/**
 * Vercel entry point for Laravel.
 * Bootstraps Laravel directly and redirects writable paths to /tmp.
 */

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);

// ── Create writable directories in /tmp ──────────────────────────────
foreach ([
    '/tmp/storage/app/public',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// ── SQLite database ───────────────────────────────────────────────────
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
}
putenv("DB_DATABASE={$dbPath}");
$_ENV['DB_DATABASE']    = $dbPath;
$_SERVER['DB_DATABASE'] = $dbPath;

// ── Fix server variables so Laravel routing works ─────────────────────
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/public/index.php';
$_SERVER['DOCUMENT_ROOT']   = $root . '/public';

// ── Bootstrap Laravel ─────────────────────────────────────────────────
require $root . '/vendor/autoload.php';

$app = require_once $root . '/bootstrap/app.php';

// Redirect storage and bootstrap cache to /tmp (Vercel is read-only everywhere else)
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

// ── Run migrations on cold start (SQLite in /tmp is ephemeral) ───────
try {
    $pdo    = new PDO('sqlite:' . $dbPath);
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='products'")->fetchAll();
    if (empty($tables)) {
        $app->make(Illuminate\Contracts\Console\Kernel::class)->call('migrate', ['--force' => true]);
    }
} catch (\Throwable $e) {
    // continue — app will surface its own error if needed
}

// ── Handle request ────────────────────────────────────────────────────
$kernel   = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request  = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
