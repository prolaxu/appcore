<?php
namespace core\Tools;
use core\Tools\Env;

class DB{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    
    public function __construct(){
        $env =new Env();
        $this->db_host=$env->db('host');
        $this->db_user=$env->db('user');
        $this->db_pass=$env->db('pass');
        $this->db_name=$env->db('name');
        $this->connect();
    }
    //Connect to database with PDO
    public function connect(){
        try{
            $this->db = new \PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_pass);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }
    public function table($table){
        $methods = new Methods($this,$table);
        return $methods;
    }
}
class Methods{
    protected $object;
    protected $table;
    protected $db;
    public function __construct($object,$table) {
        $this->object = $object;
        $this->table = $table;
        $this->db=$this->object->db;
    }
    public function get(){
        $query = $this->db->prepare("SELECT * FROM $this->table");
        $query->execute();
        return (object)$query->fetchAll();
    }
    //Find row by id
    public function find($id){
        $query = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
        return (object) $query->fetch();
    }
    //Where
    public function where($params){
        $where=""; $c=0; $values=[];
        foreach($params as $key=>$value){
            $c==count($params)-1 ? $where.="`$key` = ?" : $where.="`$key` = ? AND ";
            array_push($values,$value);
            $c++;
        }
        $sql="SELECT * FROM `$this->table` WHERE $where";
        $query = $this->db->prepare($sql);
        $query->execute($values);
        return (object) $query->fetchAll();
    }
    //Insert Record in any table
    public function insert($data){
        $keys = implode("`,`", array_keys($data));
        $values=[];
        $params_string="";
        $c=0;
        foreach($data as $key=>$value){
            $c==count($data)-1?$params_string.="?":$params_string.="?,";
            array_push($values,$value);
            $c++;
        }
        $sql="INSERT INTO `$this->table` (`id`,`$keys`) VALUES (null,$params_string)";
        $query = $this->db->prepare($sql);
        $query->execute($values);
        return (object) $this->find($this->db->lastInsertId());
    }
    //Update Record in any table
    public function update($id,$data){
        $keys = implode("`,`", array_keys($data));
        $values=[];
        $params_string="";
        $c=0;
        foreach($data as $key=>$value){
            $c==count($data)-1?$params_string.="`$key`=?":$params_string.="`$key`=?,";
            array_push($values,$value);
            $c++;
        }
        $sql="UPDATE `$this->table` SET $params_string WHERE `id` = $id";
        $query = $this->db->prepare($sql);
        $query->execute($values);
        return (object) $this->find($id);
    }
    //Delete Record in any table
    public function delete($id){
        $record=$this->find($id);
        $sql="DELETE FROM `$this->table` WHERE `id` = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return (object) $record;
    }
    //query to insert , select,update,delete data
    public function query($sql, $params = []){
        $query = $this->db->prepare($sql);
        $query->execute($params);
        return (object) $query->fetchAll();
    }
}