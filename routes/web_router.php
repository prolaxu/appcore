<?php

use core\Tools\Route;

$router = new Route();
$router->get('/', 'HomeController@index');
