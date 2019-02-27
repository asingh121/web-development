<?php
class Users{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $dob;
    public $course;
    public $address;
    public $phone_number;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read users
	function read(){
 
		// select all query
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "";
 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
 
		// execute query
		$stmt->execute();
 
		return $stmt;
	}
	
	// create user
	function create(){
	 
		// query to insert record
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					first_name=:first_name, last_name=:last_name, dob=:dob, course=:course, address=:address, phone_number=:phone_number";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->first_name=htmlspecialchars(strip_tags($this->first_name));
		$this->last_name=htmlspecialchars(strip_tags($this->last_name));
		$this->dob=htmlspecialchars(strip_tags($this->dob));
		$this->course=htmlspecialchars(strip_tags($this->course));
		$this->address=htmlspecialchars(strip_tags($this->address));
		$this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
	 
		// bind values
		$stmt->bindParam(":first_name", $this->first_name);
		$stmt->bindParam(":last_name", $this->last_name);
		$stmt->bindParam(":dob", $this->dob);
		$stmt->bindParam(":course", $this->course);
		$stmt->bindParam(":address", $this->address);
		$stmt->bindParam(":phone_number", $this->phone_number);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	// search users
	function search($keywords){
	 
		// select all query
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE
					first_name LIKE ? OR last_name LIKE ?";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$keywords=htmlspecialchars(strip_tags($keywords));
		$keywords = "%{$keywords}%";
	 
		// bind
		$stmt->bindParam(1, $keywords);
		$stmt->bindParam(2, $keywords);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}