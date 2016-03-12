<?php
	require_once("./common_db.php");
	require_once("./session.php");
	
	//Updates the cart total in the database along with the timestamp
	function updateProductAmount($prodTotal, $order_id){
		$dbo = db_connect();
		$query = "UPDATE store.order SET Order_ProductAmount = '$prodTotal', Order_TimeStamp = NOW() WHERE Order_id = ?";
		$statement = $dbo->prepare($query);
		$statement->execute(array($order_id));
	}
?>