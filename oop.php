<?php
echo "<pre>";
    
    class Table {
        public $connection;
        public $table;
        public $data;
    
        public function __construct($tableName){
            $this->table = $tableName;
            $this->connection = new mysqli("localhost", "root", "", "ecommerce2");
    
            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
    
            $this->connection->set_charset("utf8");
        }
    
        public function readAll(){
            
            $getAllData = $this->connection->query("SELECT * FROM $this->table");
            if($getAllData -> num_rows > 0){
                foreach($getAllData as $row){
                    $this->data[] = $row;
                }
                return $this->data;
            }else{
                echo "this table dose not exist or empty try again";
            }
        }

        public function read($column, $value){
            
            $getAllData = $this->connection->query("SELECT * FROM $this->table WHERE $column = $value");
            if($getAllData -> num_rows > 0){
                foreach($getAllData as $row){
                    $this->data[] = $row;
                }
                return $this->data;
            }else{
                echo "this table dose not exist or empty try again";
            }
        }

        public function insert($data) {
            $columns = implode(", ", array_keys($data));
            $values = "'" . implode("', '", array_values($data)) . "'";
    
            $insert = "INSERT INTO $this->table ($columns) VALUES ($values)";
            
            $insertData = $this->connection->query($insert);
    
            if ($insertData) {
                return "Data inserted successfully";
            } else {
                return "Error: " . $insert . "<br>" . $this->connection->error;
            }
        }


    }

    
    
    // Example usage:
    $userTable = new Table("users");
    // print_r($userTable->readAll());
    print_r($userTable->read("id",2));

?>