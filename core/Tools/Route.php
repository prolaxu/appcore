<?php 
//HTTP Route
namespace Core\Tools;
class Route{
      public $url;
      public $paths=[];
      function __construct()
      {
          $this->url="/".$_GET['url'];
          $this->url=str_replace("^","",$this->url);
      }
      //Get method
        public function get($route, $callback){
            $this->paths[]=$route;
            if($_SERVER['REQUEST_METHOD']=="GET"){
                if($this->url==$route){
                    $this->call($route,$callback);
                }
            }
        }
        //Post method
        public function post($route, $callback){
            $this->paths[]=$route;
            if($_SERVER['REQUEST_METHOD']=="POST"){
                if($this->url==$route){
                    $this->call($route,$callback);
                }
            }
        }
        public function not_found(){
            if(!in_array($this->url,$this->paths)){
                echo "404";
            }
        }
        //Call method
        private function call($route, $callback){
                try {
                    $callback();
                } catch (\Throwable $th) {
                    $classAndMethod = explode('@', $callback);
                    $class = "app\\controllers\\".$classAndMethod[0];
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