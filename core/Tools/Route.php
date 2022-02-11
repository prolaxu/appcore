<?php
//HTTP Route
namespace core\Tools;

use core\Tools\Request;

class Route
{
    public $url;
    public $paths = [];
    public $request;
    public function __construct()
    {
        $this->request = new Request();
        $this->url = $this->request->url;
    }
    //Get method
    public function get($route, $callback)
    {
        $this->paths[] = $route;
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if ($this->url == $route) {
                $this->call($route, $callback);
            }
        }
    }
    //Post method
    public function post($route, $callback)
    {
        $this->paths[] = $route;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($this->url == $route) {
                if (isset($_POST['csrf_token'])) {
                    if ($_SESSION['csrf_token'] != $_POST['csrf_token']) {
                        die("Page Expired.");
                    } else {
                        $this->call($route, $callback);
                    }
                } else {
                    die("Page Expired.");
                }
            }
        }
    }
    public function auth_middleware($callback)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
        }
    }
    public function not_found()
    {
        if (!in_array($this->url, $this->paths)) {
            echo "404";
        }
    }
    //Call method
    private function call($route, $callback)
    {
        try {
            $callback();
        } catch (\Throwable $th) {
            $classAndMethod = explode('@', $callback);
            $class = "app\\controllers\\" . $classAndMethod[0];
            $method = $classAndMethod[1];
            $controller = new $class;
            $controller->$method();
        }
    }
    public function __destruct()
    {
        $this->not_found();
    }
}
