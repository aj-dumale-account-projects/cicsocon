<?php

class Section{

    private $conn;
    private $table_name = "sections";

    public $id;
    public $created_by;
    public $section_president;
    public $section_treasurer;
    public $class_year;
    public $class_section;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    // read all user records
    function readAll($from_record_num, $records_per_page){
        // query to read all user records, with limit clause for pagination
        $query = "SELECT
                    id,
                    created_by,
                    section_president,
                    section_treasurer,
                    class_year,
                    class_section,
                    created
                FROM " . $this->table_name . "
                ORDER BY id DESC
                LIMIT ?, ?";
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind limit clause variables
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
        // execute query
        $stmt->execute();
        // return values
        return $stmt;
    }

    // used for paging users
    public function countAll(){
        // query to select all user records
        $query = "SELECT id FROM " . $this->table_name . "";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        // get number of rows
        $num = $stmt->rowCount();
        // return row count
        return $num;
    }


}


?>

