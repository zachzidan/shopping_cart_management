<?php
	require_once("./common_db.php");
	require_once("./session.php");
	
	//retrieves the subtotal from order table
	function getOrderSubtotal(){
		//only runs if cart exists in session
		if(!isset($_SESSION['order_id'])){
			$query = "SELECT Order_ProductAmount FROM store.order WHERE Order_id = ?";
			$dbo = db_connect();
			$statement = $dbo->prepare($query);
			$statement->execute(array($_SESSION['Order_id']));
			$row = $statement->fetch();
			return $row[0];
		}
		//otherwise return a value of zero
		return 0;
	}
?>