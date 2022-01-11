<?php
    use core\Tools\Route;
    use app\controllers\HomeController;
    $router= new Route();
    $router->get('/','HomeController@index');