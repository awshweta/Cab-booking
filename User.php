<?php
include_once("DbConnect.php");
class User
{
	public $username;
	public $name;
	public $dateofsignup;
	public $mobile;
	public $isblock;
	public $pass;
	public $isadmin;
	public function register($username , $name , $pass , $mobile , $conn) {
		$r = false;
		$isblock = 0;
		$isadmin = 0;
		$pass = md5($pass);
		$sqlselect = "SELECT * FROM user";
		$result = $conn->query($sqlselect);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				if($row['user_name'] == $username){
					$r=true;
				}
			}
		}
		if($r == false){
			$sql = "INSERT INTO user(`user_name`,`name`,`mobile`,`isblock`, `password`, `isadmin`) VALUES ('".$username."', '".$name."','".$mobile."','".$isblock."' ,'".$pass."','".$isadmin."')";
			if ($conn->query($sql) === true) {
				$ret = "Register successfully";
			} else {
				$ret =$conn->error;
			}
			return $ret;
		}else {
			$ret = 'Username already exist';
			return $ret;
		}
		$conn->close();
	}
	public function login($username , $pass , $conn) {
		$cookie_name = "username";
		$cookie_value = $username;
		$pass = md5($pass);
		$admin ="";
		$error = "";
		$success = "";
		$sql = "SELECT * FROM user WHERE `user_name`='$username' AND `password`='$pass'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				if($row['isblock'] == 1) {
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
					$_SESSION['user'] = array('user_name'=>$username ,'id'=>$row['id'] , 'role'=>$row['isadmin']);
					if($row['isadmin'] == 1) {
						$admin = "yes";
					}
					if($row['isadmin'] == 0){
						$admin = "no";
					}
					$success = "login successfully";
				}
				else {
					$error = "You are not approved by admin.";
				}
			}
		}
		else
		{
			$error = 'Invalid login details';
		}
		$arr = array('admin'=> $admin ,'error'=>$error , 'success' => $success);
		return $arr;
		$conn->close(); 
	}
	public function fetchBlockedUser($conn) {
		$sql = "SELECT *  FROM user WHERE `isblock` = 0 AND  `isadmin` = 0";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchApprovedUser($conn) {
		$sql = "SELECT *  FROM user WHERE `isblock` = 1  AND `isadmin` = 0";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAllUserAscName($conn) {
		$sql = "SELECT *  FROM user WHERE `isadmin` = 0 ORDER BY `name`";
		$result = $conn->query($sql);
		return $result;
	}
	
	public function fetchApproveUserAscName($conn) {
		$sql = "SELECT *  FROM user WHERE `isadmin` = 0 AND `isblock` = 1 ORDER BY `name`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchApproveUserDescName($conn) {
		$sql = "SELECT *  FROM user WHERE `isadmin` = 0 AND `isblock` = 1 ORDER BY `name` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAllUserDescName($conn) {
		$sql = "SELECT *  FROM user WHERE `isadmin` = 0 ORDER BY `name` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAllUser($conn) {
		$sql = "SELECT *  FROM user WHERE `isadmin` = 0";
		$result = $conn->query($sql);
		return $result;
	}
	public function unblock($id , $conn) {
		$sql = "UPDATE user SET `isblock` = 1 , `dateofsignup`=NOW() WHERE `id` = '$id'";

		if ($conn->query($sql) === TRUE) {
			$ret = "Unblocked successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function block($id , $conn) {
		$sql = "UPDATE user SET `isblock` = 0 WHERE `id` = '$id'";

		if ($conn->query($sql) === TRUE) {
			$ret = "Blocked successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function deleteUser($id , $conn) {
		$sqlride = "DELETE FROM ride WHERE `user_id`='$id'";
		if ($conn->query($sqlride) === TRUE) {
			$sql = "DELETE FROM user WHERE `id`='$id'";
			if ($conn->query($sql) === TRUE) {
				$ret = "Record deleted successfully";
			} else {
				$ret = "Error deleting record: " . $conn->error;
			}
		}
		 else {
			$ret = "Error deleting record: " . $conn->error;
		}
	return $ret;
}
public function getUserInformation($conn) {
	$id = $_SESSION['user']['id'];
	$sql = "SELECT *  FROM user WHERE `isblock` = 1 AND `id`='$id'";
	$result = $conn->query($sql);
	return $result;
}
public function updateUserInfo($name , $mobile ,$conn) {
	$id = $_SESSION['user']['id'];
	$sql = "UPDATE user SET `name` = '$name' ,`mobile`='$mobile' WHERE `id` = '$id'";
	if ($conn->query($sql) === TRUE) {
		$ret = "Update successfully";
	} else {
		$ret = "Error updating record: " . $conn->error;
	}
	return $ret;
}
public function updatePassword($oldPass , $newPass ,$conn) {
	$id = $_SESSION['user']['id'];
	$oldPass = md5($oldPass);
	$newPass = md5($newPass);
	$success = "";
	$error = "";
	$sqls = "SELECT * FROM user WHERE `id`='$id'";
	$results = $conn->query($sqls);
	if($results->num_rows > 0) {
		while($rows = $results->fetch_assoc()){
			$pass = $rows['password'];
				//echo $pass;
			if($pass == $oldPass) {
				$sql = "UPDATE user SET `password` = '$newPass' WHERE `id` = '$id'";
				if ($conn->query($sql) === TRUE) {
					$success = "Update successfully";
				} else {
					$error = "Error updating record: " . $conn->error;
				}
			}
			else {
				$error = "please enter correct password";
			}
		}
	}
	$arr = array('success'=>$success , 'error'=>$error);
	return $arr;
}
}
?>