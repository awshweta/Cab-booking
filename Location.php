<?php
include_once("DbConnect.php");
class Location
{
	public $location;
	public $distance;
	public $name;
	public $is_available;

	public function add($name , $distance , $conn) {
		$r = false;
		$success ="";
		$error ="";
		$sqlselect = "SELECT * FROM location";
		$result = $conn->query($sqlselect);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				if($row['name'] == $name){
					$r=true;
				}
			}
		}
		if($r == false) {
			$sql = "INSERT INTO location(`name`,`distance`,`is_available`) VALUES ('".$name."', '".$distance."' ,1)";
			if ($conn->query($sql) === true) {
				$success = "Location added successfully";
			} else {
				$error =$conn->error;
			}
		}
		else {
			$error = "location name already exist";
		}
		$arr = array('success' => $success , 'error'=>$error);
		return $arr;
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
		$sql = "DELETE FROM location WHERE `id`='$id'";
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
		$success ="";
		$error = "";
		$r = false;
		$sqlselect = "SELECT * FROM location";
		$result = $conn->query($sqlselect);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				if($row['name'] == $name && $row['id'] != $id){
					$r=true;
				}
			}
		}
		if($r == false) {
			$sql = "UPDATE location SET `name`='$name', `distance`='$distance' WHERE `id`='$id'";
			if ($conn->query($sql) === TRUE) {
				$success = "Location updated successfully";
			} else {
				$error = "Error updating record: " . $conn->error;
			}
		}
		else {
			$error = "Location name already exixt";
		}
		$arr = array('success' => $success , 'error'=>$error);
		return $arr;
	}
}
?>