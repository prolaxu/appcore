<?php

namespace core\Tools;
use core\Tools\Render;

class BaseController{
    protected $twig;
    public function __construct(){
        $this->twig=new Render();
    }
    public function view($view, $data = []){
        echo $this->twig->render($view,$data);
    }
}