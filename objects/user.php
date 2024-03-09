<?php

class User{

    private $conn;
    private $table_name = 'users';

    public $id;
    public $firstname;
    public $middlename;
    public $lastname;
    public $email_address;
    public $password;
    public $student_id;
    public $access_level;
    public $section;
    public $year;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    // check if given email exist in the database
    function emailExists(){
        // query to check if email exists
        $query = "SELECT id, firstname, middlename, lastname, access_level, password, section, year
                FROM " . $this->table_name . "
                WHERE email_address = ?
                LIMIT 0,1";
        // prepare the query
        $stmt = $this->conn->prepare( $query );
        // sanitize
        $this->email_address=htmlspecialchars(strip_tags($this->email_address));
        // bind given email value
        $stmt->bindParam(1, $this->email_address);
        // execute the query
        $stmt->execute();
        // get number of rows
        $num = $stmt->rowCount();
        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // assign values to object properties
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->middlename = $row['middlename'];
            $this->lastname = $row['lastname'];
            $this->access_level = $row['access_level'];
            $this->password = $row['password'];
            $this->section = $row['section'];
            $this->year = $row['year'];
            // return true because email exists in the database
            return true;
        }
        // return false if email does not exist in the database
        return false;
    }
    // create new user record
    function create(){
        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    firstname = :firstname,
                    middlename = :middlename,
                    lastname = :lastname,
                    email_address = :email_address,
                    password = :password,
                    access_level = :access_level,
                    created = :created";
        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->middlename=htmlspecialchars(strip_tags($this->middlename));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email_address=htmlspecialchars(strip_tags($this->email_address));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->access_level=htmlspecialchars(strip_tags($this->access_level));
        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':middlename', $this->middlename);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email_address', $this->email_address);
        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':access_level', $this->access_level);
        $stmt->bindParam(':created', $this->created);
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }
}
?>