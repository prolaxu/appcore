<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    include_once $className . '.php';
});
include_once __DIR__ . '/app/middleware.php';
include_once __DIR__ . '/core/methods.php';
include_once __DIR__ . '/routes/web_router.php';
