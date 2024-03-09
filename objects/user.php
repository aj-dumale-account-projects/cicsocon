<?php

class User{

    private $conn;
    private $table_name;

    public $id;
    public $firstname;
    public $middlename;
    public $lastname;
    public $email_address;
    public $password;
    public $student_id;
    public $role;
    public $section;
    public $year;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    
}
?>