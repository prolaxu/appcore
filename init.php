<?php
    require __DIR__.'/vendor/autoload.php';
    spl_autoload_register(function($className) {
        $className = str_replace('\\', '/', $className);
        include_once $className . '.php';
    });
    include_once 'routes/web_router.php';