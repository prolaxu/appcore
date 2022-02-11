<?php

namespace core;

use core\Tools\Request;
use core\Tools\Env;
use core\Tools\Auth;
use core\Tools\DB;

class MethodsClass
{

    public function request()
    {
        return new Request();
    }
    public function routePath($path)
    {
        $new_path = $path[0] == "/" ? $path : "/" . $path;
        return request()->root . $new_path;
    }
    public function env()
    {
        $env = new Env();
        return $env;
    }
    public function dd($data)
    {
        echo "<div style=\"padding: .2rem;padding-left: 2rem; font-family: sans-serif;background:#000; color: rgb(54, 184, 3); border-radius: .5rem;\"><pre>";
        print_r($data);
        echo "</pre></div>";
        die();
    }
    public function getVar(&$var)
    {
        $tmp = $var; // store the variable value
        $var = '_$_%&33xc$%^*7_r4'; // give the variable a new unique value
        $name = array_search($var, $GLOBALS); // search $GLOBALS for that unique value and return the key(variable)
        $var = $tmp; // restore the variable old value
        return $name;
    }
    public function auth()
    {
        return new Auth();
    }
    public function run($callback)
    {
        return $callback();
    }
    public function errors()
    {
        return $_SESSION['errors'] ?? [];
    }
    public function setError($key, $error)
    {
        $_SESSION['errors'][$key] = $error;
    }
    public function getError($key)
    {
        return $_SESSION['errors'][$key] ?? null;
    }
    public function csrf()
    {
        return $_SESSION['csrf_token'];
    }
    public function csrf_verify($token)
    {
        return $token == $_SESSION['csrf_token'];
    }
    public function db()
    {
        return  new Db();
    }
    public function datetime($date)
    {
        return [date("Y-m-d", strtotime($date)), date("h:i:s", strtotime($date))];
    }
}
