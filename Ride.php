<?php
include_once("DbConnect.php");
class Ride {
	public $from;
	public $to;
	public $cab_type;
	public $totaldistance;
	public $totalfare;
	public $luggage;
	public $status;

	public function getdistance($a , $b) {
		if($a >= $b) {
			$d = $a - $b;
		}
		else {
			$d = $b - $a;
		}
		return $d;
	}
	public function calculateFare($d , $wt ,$fixedFare ,$d1 ,$d2 ,$d3 ,$d1price ,$d2price ,$d3price ,$d4price ,$charge ) {
		$w1price = 50;
		$w2price = 100;
		$w3price = 200;
		if($d > 0 && $d  <= $d1) {
			if($wt == 0) {
				$fare = ($d1*$d1price)+ $fixedFare;
				return $fare;
			}
			elseif($wt >0 && $wt <= 10) {
				$fare = ($d*$d1price) + $w1price*$charge + $fixedFare;
				return $fare;
			}
			elseif(10 < $wt && $wt <= 20) {
				$fare = ($d*$d1price) + $w2price*$charge + $fixedFare;
				return $fare;
			}
			else {
				$fare = ($d*$d1price) + $w3price*$charge + $fixedFare;
				return $fare;
			}
		}
		elseif($d  > $d1 && $d <= ($d1+$d2)) {
			$dsub = $d-$d1;
			//echo $dsub;
			if($wt == 0) {
				$fare = ($d1*$d1price) + ($dsub*$d2price)  + $fixedFare;
				return $fare;
			}
			elseif($wt>0 && $wt <= 10) {
				$fare = ($d1*$d1price) + ($dsub*$d2price) + $w1price*$charge + $fixedFare;
				return $fare;
			}
			elseif(10 < $wt && $wt <= 20) {
				$fare = ($d1*$d1price) + ($dsub*$d2price) + $w2price*$charge + $fixedFare;
				return $fare;
			}
			else {
				$fare = ($d1*$d1price) + ($dsub*$d2price) + $w3price*$charge + $fixedFare;
				return $fare;
			}
		}
		elseif($d  > 60 && $d <= ($d1+$d2+$d3)) {
			$dsub = $d-$d2- $d1;
			if($wt == 0) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($dsub*$d3price)  + $fixedFare;
				return $fare;
			}
			elseif($wt >0 && $wt <= 10) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($dsub*$d3price) + $w1price*$charge + $fixedFare;
				return $fare;
			}
			elseif(10 < $wt && $wt <= 20) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($dsub*$d3price) + $w2price*$charge + $fixedFare;
				return $fare;
			}
			else {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($dsub*$d3price) + $w3price*$charge + $fixedFare;
				return $fare;
			}
		}
		elseif($d > ($d1+$d2+$d3)) {
			$dsub = $d -$d1 -$d2 -$d3;
			if($wt == 0) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($d3*$d3price) + ($dsub*$d4price) + $fixedFare;
				return $fare;
			}
			if($wt > 0 && $wt <= 10) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($d3*$d3price) + ($dsub*$d4price) + $w1price*$charge + $fixedFare;
				return $fare;
			}
			elseif(10 < $wt && $wt <= 20) {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($d3*$d3price) + ($dsub*$d4price) + $w2price*$charge + $fixedFare;
				return $fare;
			}
			else {
				$fare = ($d1*$d1price) + ($d2*$d2price) + ($d3*$d3price) + ($dsub*$d4price) + $w3price*$charge + $fixedFare;
				return $fare;
			}
		}
	}
	public function display($pickup , $drop ,$wt , $cab) {
		$status = 1;
		$d = null;
		$d1=10;
		$d2 =50;
		$d3 = 100;
		$fare = '';
		$html ='';
		if($cab == "CedMini") {
			$d1price= 14.50;
			$d2price = 13.00;
			$d3price = 11.2;
			$d4price = 9.5;
			$fixedFare = 150;
			$charge =1;
		}
		elseif($cab == "CedMicro") {
			$d1price= 13.50;
			$d2price = 12.00;
			$d3price = 10.2;
			$d4price = 8.5;
			$fixedFare = 50;
			$charge =1;
		}
		elseif($cab == "CedRoyal") {
			$d1price= 15.50;
			$d2price = 14.00;
			$d3price = 12.2;
			$d4price = 10.5;
			$fixedFare = 200;
			$charge =1;
		}
		elseif($cab == "CedSUV") {
			$d1price= 16.50;
			$d2price = 15.00;
			$d3price = 13.2;
			$d4price = 11.5;
			$fixedFare = 250;
			$charge = 2;
		}
		$db = new DbConnect();
		$sql = "SELECT *  FROM location";
		$result = $db->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($rowpick = $result->fetch_assoc()) {
				if($pickup == $rowpick['name']) {
					$dis1  = $rowpick['distance'];
					$sqlsec = "SELECT *  FROM location";
					$resultsec = $db->conn->query($sqlsec);
					if ($resultsec->num_rows > 0) {
						while ($row = $resultsec->fetch_assoc()) {
							if($drop == $row['name']) {
								$dis2 = $row['distance'];
								$d = $this->getdistance($dis1 , $dis2);
								if($d == 0) {
									$fare = "0";
								}
								else {
									$fare = $this->calculateFare($d ,$wt ,$fixedFare ,$d1,$d2 ,$d3 , $d1price ,$d2price ,$d3price ,$d4price ,$charge);
								}
								$arr = array('luggage' => $wt ,'distance'=>$d ,'totalfare'=> $fare);
								return $arr;
							}
						}
					}
				}
			}
		}
	}
	public function booking($pickup ,$drop,$cab ,$wt ,$distance ,$fare ,$conn) {
		$status = 1;
		$user_id = $_SESSION['user']['id'];
		$sql = "INSERT INTO ride (`from`,`to`,`cab_type`,`totaldistance`,`luggage`,`totalfare`,`status`, `user_id`) VALUES ('".$pickup."','".$drop."','".$cab."','".$distance."','".$wt."' ,'".$fare."','".$status."','".$user_id."')";
		if ($conn->query($sql) === true) {
			$ret  = array('from'=>$pickup ,'to'=>$drop , 'totaldistance'=>$distance ,'luggage'=>$wt ,'cab_type'=>$cab,'totalfare'=>$fare ,'status'=>"Pending");
		} else {
			$ret =$conn->error;
		}
		return $ret;
	}
	public function fetchPendingRequest($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id` ='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAscDatePendingRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1 ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchDescDatePendingRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1 ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAscFarePendingRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1 ORDER BY `totalfare`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchDescFarePendingRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1 ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAscDateCustomerPendingRide($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id` ='$id' ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchAscFareCustomerPendingRide($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id` ='$id' ORDER BY `totalfare`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchDescFareCustomerPendingRide($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id` ='$id' ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchDescDateCustomerPendingRide($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id` ='$id' ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchLastPendingRequest($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1 ORDER BY `id` DESC LIMIT 1";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchLastPendingCustomerRequest($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 1 AND `user_id`='$id' ORDER BY `id` DESC LIMIT 1";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRideRequest($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 1";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRideASC($conn) {
		$sql = "SELECT *  FROM ride ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRideASCFare($conn) {
		$sql = "SELECT *  FROM ride ORDER BY `totalfare` ASC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCompletedASC($conn) {
		$status = 2;
		$sql = "SELECT *  FROM ride WHERE `status`='$status' ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRideDESC($conn) {
		$sql = "SELECT *  FROM ride ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerRideDESC($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCusertomerCompDateASC($conn) {
		$status = 2;
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' AND `status`='$status' ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerASCFare($conn) {
		$status = 2;
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' AND `status`='$status' ORDER BY `totalfare`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerCompDESCFare($conn) {
		$status = 2;
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' AND `status`='$status' ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCusertomerCompDateDESC($conn) {
		$status = 2;
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' AND `status`='$status' ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRideDESCFare($conn) {
		$sql = "SELECT *  FROM ride ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerDESCFare($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCusertomerPendingDateASC($conn) {
		$status = 1;
		$id=$_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status`='$status' AND `user_id`='$id' ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCompletedDESC($conn) {
		$status = 2;
		$sql = "SELECT *  FROM ride WHERE `status`='$status' ORDER BY `date` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCompletedfareDESC($conn) {
		$status = 2;
		$sql = "SELECT *  FROM ride WHERE `status`='$status' ORDER BY `totalfare` DESC";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCompletedfareASC($conn) {
		$status = 2;
		$sql = "SELECT *  FROM ride WHERE `status`='$status' ORDER BY `totalfare`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchRide($conn) {
		$sql = "SELECT *  FROM ride";
		$result = $conn->query($sql);
		return $result;
	}
	public function sortAllCustomerRide($cab, $conn) {
		$id = $_SESSION['user']['id'];
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `user_id`='$id' AND `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `user_id`='$id' AND `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `user_id`='$id' AND `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function sortAllRide($cab, $conn) {
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function sortCompletedRide($cab, $conn) {
		$status = 2;
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `status`='$status' AND `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `status`='$status' AND `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `status`='$status' AND `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function sortallPendingRide($cab, $conn) {
		$status = 1;
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `status`='$status' AND `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `status`='$status' AND `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `status`='$status' AND `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function sortCustomerCompletedRide($cab, $conn) {
		$id = $_SESSION['user']['id'];
		$status = 2;
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `status`='$status' AND `user_id`='$id' AND `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `status`='$status' AND `user_id`='$id' AND `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `status`='$status' AND `user_id`='$id' AND `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function sortCustomerPendingRide($cab, $conn) {
		$id = $_SESSION['user']['id'];
		$status = 1;
		if($cab == "LastWeek") {
			$sql ="SELECT * FROM ride
			WHERE `status`='$status' AND `user_id`='$id' AND `date` BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
			$result = $conn->query($sql);
			return $result;
		}
		else if($cab == "LastMonth") {
			$sql = "SELECT * FROM ride
			WHERE `status`='$status' AND `user_id`='$id' AND `date` >= (CURRENT_DATE - INTERVAL 1 MONTH)";
			$result = $conn->query($sql);
			return $result;
		}
		else {
			$sql = "SELECT *  FROM ride WHERE `status`='$status' AND `user_id`='$id' AND `cab_type`='$cab'";
			$result = $conn->query($sql);
			return $result;
		}
	}
	public function fetchallRide($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerRideASC($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' ORDER BY `date`";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCustomerRideASCFare($conn) {
		$id = $_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `user_id`='$id' ORDER BY `totalfare`";
		$result = $conn->query($sql);
		return $result;
	}
	public function approve($id , $conn) {
		$sql = "UPDATE ride SET `status` = 2 WHERE `id` = '$id'";

		if ($conn->query($sql) === TRUE) {
			$ret = "Approved successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function invoice($id , $conn) {
		$sql = "SELECT *  FROM ride WHERE `id`='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	public function cancel($id , $conn) {
		$sql = "UPDATE ride SET `status` = 0 WHERE `id` = '$id'";

		if ($conn->query($sql) === TRUE) {
			$ret = "cancel successfully";
		} else {
			$ret = "Error updating record: " . $conn->error;
		}
		return $ret;
	}
	public function deleteRide($id , $conn) {
		$sql = "DELETE FROM ride WHERE `id`='$id'";
		if ($conn->query($sql) === TRUE) {
			$ret = "Record deleted successfully";
		} else {
			$ret = "Error deleting record: " . $conn->error;
		}
		return $ret;
	}
	public function fetchApprovedRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 2";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCompletedRide($conn) {
		$id =$_SESSION['user']['id'];
		$sql = "SELECT *  FROM ride WHERE `status` = 2 AND `user_id` ='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	public function fetchCancelRide($conn) {
		$sql = "SELECT *  FROM ride WHERE `status` = 0";
		$result = $conn->query($sql);
		return $result;
	}
}

?>