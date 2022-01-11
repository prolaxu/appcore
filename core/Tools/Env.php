<?php
//env.json file reader
namespace Core\Tools;
Class Env{
    protected $env;
    public function __construct(){
        $this->env = json_decode(file_get_contents(__DIR__.'/../../env.json'), true);
    }
    public function get($key){
        return $this->env[$key];
    }
    public function db($key){
        return $this->env['database'][$key];
    }
}