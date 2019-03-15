<?php

class Categories
{
    private $table = "categories";
    private $category_id;
    private $category_name;
    private $category_status;
    private $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
    }
    
    function readAllCategories(){
        $sql = "SELECT * FROM {$this->table}";
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
    
    function createCategory($data){
        $columnString = implode(", ", array_keys($data));
        $valueString = ":".implode(", :",array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$columnString}) VALUES ({$valueString})";
        $ps = $this->conn->prepare($sql);
        $result = $ps->execute($data);
        if($result){
            return $this->conn->lastInsertId();
        }else{
            return false;
        }
    }
    
    
    
//    return no of rows affected on successsful updation
//    else return false
    
    function updateCategory($data, $condition){
        $i=0;
        $columnValueSet = "";
        foreach($data as $key=>$value){
            $comma = ($i<count($data)-1?", ":"");
            $columnValueSet .= $key. "='".$value."'".$comma;
            $i++;
        }
        
        $sql = "UPDATE $this->table SET $columnValueSet WHERE $condition";
        $ps = $this->conn->prepare($sql);
        
        $result = $ps->execute();
        if($result){
            return $ps->rowCount();
        }else{
            return false;
        }
    }
    
    function getCategoryName($category_id){
        $sql = "SELECT category_name FROM {$this->table} WHERE category_id = $category_id";
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetch();
        return $result['category_name'];
    }
    
    function readAllActiveCategories(){
        $sql = "SELECT * FROM {$this->table} WHERE category_status='active'";
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
    
}

?>