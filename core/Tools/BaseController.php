<?php

namespace core\Tools;

use core\Tools\Render;

class BaseController
{
    public function view($view, $data = [])
    {
        $twig = new Render();
        echo $twig->render($view, $data);
        unset($_SESSION['errors']);
    }
}
