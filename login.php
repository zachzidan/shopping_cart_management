<?php

require_once("common_db.php");

function check_credentials($username, $password) {
	$query  = "SELECT shopper_id, sh_password FROM Shopper ";
	$query .= "WHERE sh_username = ?";
		
	$dbo = db_connect();
		
	$statement = $dbo->prepare($query);
	$statement->execute(array($username));

	$row = $statement->fetch();
	if ($row[0] > 0) {
		if (password_verify($password, $row[1]))
			return($row[0]);
		else 
			return(0);
	}
	else {
		return(0);
	}
}

function login($username, $password) {
	$shopper_id = check_credentials($username, $password);
	if ($shopper_id > 0) {
		session_regenerate_id(TRUE);

		$sessid = session_id();
		$dbo = db_connect();

		$query  = "INSERT INTO Session (id, Shopper_id) VALUES (?,?)";
		
		try {
			$statement = $dbo->prepare($query);
			$success = $statement->execute(array($sessid, $shopper_id));
		}
		catch (PDOException $ex) {
			error_log($ex->getMessage());
			die($ex->getMessage());
		}
		//attempts to get the most recent cart object
		checkCart($shopper_id);
		return (TRUE);
	}
	else {
		return (FALSE);
	}
}

function logout() {
	
	session_regenerate_id(TRUE);
	session_destroy();
	// End the session;
}

function checkCart($shopper_id) {
	//generate connection to database
	$dbo = db_connect();
	//check if user has cart stored in there session variable
	if (isset($_SESSION['Order_id'])){
		//move the cart from a guest user over to the user that logged in
		$query = "UPDATE store.order SET Order_Shopper = ?, Order_TimeStamp = NOW() WHERE Order_id = ?";
		try {
			$statement = $dbo->prepare($query);
			$success = $statement->execute(array($shopper_id, $_SESSION['Order_id']));
		}
		catch (PDOException $ex) {
			error_log($ex->getMessage());
			die($ex->getMessage());
		}
	}
	//otherwise check if there is a instance stored in the database and place into session
	else{
		//get most recent order row that hasnt been finalised
		$query = "SELECT Order_id FROM store.order WHERE Order_Shopper = ? AND Order_PaymentAuthorized = 0 ORDER BY Order_TimeStamp DESC";
		try {
			$statement = $dbo->prepare($query);
			$success = $statement->execute(array($shopper_id));
			$row = $statement->fetch();
			//if there is an order in database
			if($row[0] > 0){
				//stores order id in session
				$_SESSION['Order_id'] = $row[0];
			}
		}
		catch (PDOException $ex) {
			error_log($ex->getMessage());
			die($ex->getMessage());
		}
	}
}