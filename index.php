<?php

/**
 * Laravel — root index.php
 * Memungkinkan akses tanpa /public di URL (XAMPP dev setup).
 */

// Ganti path ke public/
$publicPath = __DIR__ . '/public';

// Override $_SERVER agar Laravel tahu root yang benar
$_SERVER['SCRIPT_FILENAME'] = $publicPath . '/index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['DOCUMENT_ROOT']   = $publicPath;

// Jalankan front controller Laravel
chdir($publicPath);
require $publicPath . '/index.php';
