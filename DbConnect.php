<?php
session_start();
class DbConnect {
	public $conn;
	public function __construct() {
		$this->conn = new mysqli("localhost" , "root" , "" , "Cab");
		if($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
		return "connected successfully";
	}
}
?>