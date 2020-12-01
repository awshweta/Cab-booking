<?php 
include_once("Ride.php");
include_once("User.php");
include_once("Location.php");
if(isset($_POST['action'])) {
	if($_POST['action'] == 'calculatefare'){
		$pickup = isset($_POST['pickup']) ? $_POST['pickup'] : '';
		$drop = isset($_POST['drop']) ? $_POST['drop'] : '';
		$wt = isset($_POST['wt']) ? $_POST['wt'] : 0 ;
		$cab = isset($_POST['cab']) ? $_POST['cab'] :'';
		$ride = new Ride();
		$arr = $ride->display($pickup , $drop ,$wt ,$cab);
		echo json_encode($arr);
	}
	if($_POST['action'] == 'booking') {
		$pickup = $_POST['pickup'];
		$drop =$_POST['drop'];
		$wt = $_POST['wt'];
		$cab = $_POST['cab'];
		$distance = $_POST['distance'];
		$fare = $_POST['fare'];
		$html ='';
		if(isset($_SESSION['user'])) {
			$db = new DbConnect();
			$ride = new Ride();
			$arr = $ride->booking($pickup , $drop,$cab ,$wt ,$distance , $fare ,$db->conn);
		}
		else {
			$_SESSION['ride'] = array('pickup'=>$pickup ,'drop'=>$drop , 'distance'=>$distance ,'cab'=>$cab ,'wt'=>$wt ,'fare'=>$fare);
			$arr = '';
		}
		echo json_encode($arr);
	}
	if($_POST['action'] == 'riderequest') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRideRequest($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'asc') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRideASC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascRide') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerRideASC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRideASCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascallfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerRideASCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'desc') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRideDESC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descDate') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerRideDESC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descCustomerfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerDESCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRideDESCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascCompletedRide') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCompletedASC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascCompDate') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCusertomerCompDateASC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descCompDate') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCusertomerCompDateDESC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascCompfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerASCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descCompfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCustomerCompDESCFare($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'sortCustomerAllRide') {
		$cab = $_POST['val'];
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->sortAllCustomerRide($cab, $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'sortallRide') {
		$cab = $_POST['val'];
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->sortAllRide($cab, $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'sortCompletedRide') {
		$cab = $_POST['val'];
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->sortCompletedRide($cab, $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'sortCustomerCompletedRide') {
		$cab = $_POST['val'];
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->sortCustomerCompletedRide($cab, $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descCompletedRide') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCompletedDESC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascCompletedfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCompletedfareASC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descCompletedfare') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCompletedfareDESC($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'pendingRequest') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchPendingRequest($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ride') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchRide($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'allride') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchallRide($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'allowRide') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchApprovedRide($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'completedRide') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCompletedRide($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'cancelledRequest') {
		$db = new DbConnect();
		$ride = new Ride();
		$data = array();
		$arr = $ride->fetchCancelRide($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'approve') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$ride = new Ride();
		$arr = $ride->approve($id , $db->conn);
		$ride = array('ride'=>$arr);
		echo json_encode($ride);
	}
	if($_POST['action'] == 'cancel') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$ride = new Ride();
		$arr = $ride->cancel($id , $db->conn);
		$ride = array('ride'=>$arr);
		echo json_encode($ride);
	}
	if($_POST['action'] == 'deleteRide') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$ride = new Ride();
		$arr = $ride->deleteRide($id , $db->conn);
		$ride = array('ride'=>$arr);
		echo json_encode($ride);
	}
	if($_POST['action'] == 'invoice') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$ride = new Ride();
		$arr = $ride->invoice($id , $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'blocked') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->fetchBlockedUser($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'users') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->fetchAllUser($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'ascName') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->fetchAllUserAscName($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'descName') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->fetchAllUserDescName($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'approvedUser') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->fetchApprovedUser($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'unblock') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$user = new User();
		$arr = $user->unblock($id , $db->conn);
		$user = array('user'=>$arr);
		echo json_encode($user);
	}
	if($_POST['action'] == 'block') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$user = new User();
		$arr = $user->block($id , $db->conn);
		$user = array('user'=>$arr);
		echo json_encode($user);
	}
	if($_POST['action'] == 'deleteUser') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$user = new User();
		$arr = $user->deleteUser($id , $db->conn);
		$user = array('user'=>$arr);
		echo json_encode($user);
	}
	if($_POST['action'] == 'getlocation') {
		$db = new DbConnect();
		$location = new Location();
		$data = array();
		$arr = $location->getLocation($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'updateUser') {
		$db = new DbConnect();
		$user = new User();
		$data = array();
		$arr = $user->getUserInformation($db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'updateUserInfo') {
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		$db = new DbConnect();
		$user = new User();
		$arr = $user->updateUserInfo($name , $mobile ,$db->conn);
		$user = array('user'=>$arr);
		echo json_encode($user);
	}
	if($_POST['action'] == 'savePass') {
		$oldPass = isset($_POST['oldPass']) ? $_POST['oldPass'] : '';
		$newPass = isset($_POST['newPass']) ? $_POST['newPass'] : '';
		$db = new DbConnect();
		$user = new User();
		$arr = $user->updatePassword($oldPass , $newPass ,$db->conn);
		echo json_encode($arr);
	}
	if($_POST['action'] == 'deleteLocation') {
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$db = new DbConnect();
		$location = new Location();
		$arr = $location->deleteLocation($id,$db->conn);
		echo json_encode($arr);
	}
	if($_POST['action'] == 'dissableLocation') {
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$db = new DbConnect();
		$location = new Location();
		$arr = $location->dissableLocation($id,$db->conn);
		echo json_encode($arr);
	}
	if($_POST['action'] == 'enableLocation') {
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$db = new DbConnect();
		$location = new Location();
		$arr = $location->enableLocation($id,$db->conn);
		echo json_encode($arr);
	}
	if($_POST['action'] == 'editlocation') {
		$id = $_POST['id'];
		$db = new DbConnect();
		$location = new Location();
		$data = array();
		$arr = $location->editLocation($id , $db->conn);
		if($arr->num_rows > 0) {
			while($row = $arr->fetch_assoc()){
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
	if($_POST['action'] == 'saveLocation') {
		$id = isset($_POST['id']) ? $_POST['id'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$distance = isset($_POST['distance']) ? $_POST['distance'] : '';
		$db = new DbConnect();
		$location = new Location();
		$arr = $location->saveLocation($id ,$name ,$distance,$db->conn);
		echo json_encode($arr);
	}

}
?>