<?php 
 namespace core\Tools;
 use \Twig\Loader\FilesystemLoader;
 use \Twig\Environment;

 class Render{
     private $loader;
     private $twig;
     public function __construct(){
        $this->loader = new FilesystemLoader(__DIR__.'/../../views');
        $this->twig = new Environment($this->loader);
     }
     public function render($view,$data=[]){
         return $this->twig->render($view.".view.php",$data);
     }
 }
