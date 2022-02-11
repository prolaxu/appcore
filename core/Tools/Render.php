<?php

namespace core\Tools;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use  core\MethodsClass;
use core\Tools\Env;

class Render
{
    private $loader;
    private $twig;
    public function __construct()
    {
        $env = new Env();
        $settings = [];
        $settings['cache'] = $env->get("cache");
        $settings['debug'] = $env->get("debug");
        $this->loader = new FilesystemLoader(__DIR__ . '/../../views');
        $this->twig = new Environment($this->loader, $settings);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }
    public function render($view, $data = [])
    {
        $methods = new MethodsClass;
        $csrf = $_SESSION['csrf_token'];
        return $this->twig->render($view . ".php", array_merge($data, [
            "function" => $methods,
            'csrf' => $csrf,
            '_csrf' => "<input type='text' value='$csrf' name='csrf_token' style='display:none;'>"
        ]));
    }
}
