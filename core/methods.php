<?php

use core\Tools\Request;
use core\Tools\Env;
use core\Tools\Auth;
use core\Tools\Render;
use core\Tools\DB;

function request()
{
    return new Request();
}
function routePath($path)
{
    $new_path = $path[0] == "/" ? $path : "/" . $path;
    return request()->root . $new_path;
}
function env()
{
    $env = new Env();
    return $env;
}
function dd($data)
{
    echo "<div style=\"padding: .2rem;padding-left: 2rem; font-family: sans-serif;background:#000; color: rgb(54, 184, 3); border-radius: .5rem;\"><pre>";
    print_r($data);
    echo "</pre></div>";
    die();
}
function getVar(&$var)
{
    $tmp = $var; // store the variable value
    $var = '_$_%&33xc$%^*7_r4'; // give the variable a new unique value
    $name = array_search($var, $GLOBALS); // search $GLOBALS for that unique value and return the key(variable)
    $var = $tmp; // restore the variable old value
    return $name;
}
function auth()
{
    return new Auth();
}
function setError($key, $error)
{
    $_SESSION['errors'][$key] = $error;
}
function getError($key)
{
    return $_SESSION['errors'][$key] ?? null;
}
function getErrors()
{
    return $_SESSION['errors'] ?? [];
}
function csrf()
{
    return $_SESSION['csrf_token'];
}
function csrf_verify($token)
{
    return $token == $_SESSION['csrf_token'];
}
function view($path, $data = [])
{
    $render = new Render();
    return $render->render($path, $data = []);
}
function arrayToObject($array)
{
    $object = new stdClass();
    foreach ($array as $key => $value) {
        $object->$key = $value;
    }
    return $object;
}
function db()
{
    return  new Db();
}
