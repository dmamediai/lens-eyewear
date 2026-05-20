<?php

/**
 * Vercel entry point for Laravel.
 * Routes all requests through Laravel's front controller.
 */

// Set the public path to /public relative to this file's parent
define('LARAVEL_START', microtime(true));

// Bootstrap the application from the project root
$root = dirname(__DIR__);

// Initialise SQLite DB in /tmp (writable on Vercel) on first boot
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    touch($dbPath);
}
putenv("DB_DATABASE={$dbPath}");
$_ENV['DB_DATABASE']    = $dbPath;
$_SERVER['DB_DATABASE'] = $dbPath;

// Rewrite the request URI so Laravel's router sees the correct path
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/public/index.php';
$_SERVER['DOCUMENT_ROOT']   = $root . '/public';

// Hand off to Laravel's public/index.php
chdir($root . '/public');
require $root . '/public/index.php';
