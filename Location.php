<?php
include_once("DbConnect.php");
class Location
{
	public $location;
	public $distance;

	public function add($name , $distance , $conn) {
		$sql = "INSERT INTO location(`name`,`distance`,`is_available`) VALUES ('".$name."', '".$distance."' ,1)";
		if ($conn->query($sql) === true) {
			$ret = "Location added successfully";
		} else {
			$ret =$conn->error;
		}
		return $ret;
		$conn->close(); 
	}
	public function getLocation($conn) {
		$sql = "SELECT *  FROM location";
		$result = $conn->query($sql);
		return $result;
	}
	public function getAvailableLocation($conn) {
		$sql = "SELECT *  FROM location WHERE `is_available` = 1";
		$result = $conn->query($sql);
		return $result;
	}
	public function deleteLocation($id , $conn) {
		$sql = "DELETE FROM location WHERE `id`='$id' AND is_available = 1";
		if ($conn->query($sql) === TRUE) {
			$ret = "Record deleted successfully";
		} else {
			$ret = "Error deleting record: " . $conn->error;
		}
		return $ret;
	}
	public function dissableLocation($id , $conn) {
		$sql = "UPDATE location SET `is_available` = 0 WHERE `id` = '$id'";
		if ($conn->query($sql) === TRUE) {
			$ret = "dissabled successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function enableLocation($id , $conn) {
		$sql = "UPDATE location SET `is_available` = 1 WHERE `id` = '$id'";
		if ($conn->query($sql) === TRUE) {
			$ret = "location available successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function editLocation($id , $conn) {
		$sql = "SELECT *  FROM location WHERE `id` = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	public function saveLocation($id , $name , $distance , $conn) {
		$sql = "UPDATE location SET `name`='$name', `distance`='$distance' WHERE `id`='$id'";
		if ($conn->query($sql) === TRUE) {
			$ret = "Location updated successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
}
?>