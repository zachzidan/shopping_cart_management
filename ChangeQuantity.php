<?php

require_once("./common_db.php");
require_once("./session.php");
require_once("./config.php");
include ("./calculateSubtotal.php");
include ("./updateProductAmount.php");

	$dbo = db_connect();
	$order_id = $_SESSION['Order_id'];
	
	//Check that a productid and quantity have been sent through via POST or GET
	if(isset($_POST['OP_id']) && isset($_POST['OP_qty'])){
		$opdid = $_POST['OP_id'];
		$qty = $_POST['OP_qty'];
	}
	elseif(isset($_GET['OP_id']) && isset($_GET['OP_qty'])){
		$opid = $_GET['OP_id'];
		$qty = $_GET['OP_qty'];
	}
	else {
		return null;
	}
	
	//Query to update the quantity of items
	$query = "UPDATE orderproduct
				SET OP_qty = ?
				WHERE OP_id = ?";
	
	//Execute the statements
	$statement = $dbo->prepare($query);
	$statement->execute(array($qty, $opid));
	
	//Updates the product subtotal and cart subtotal
	updateProductAmount(calculateOrderSubtotal(),$order_id);	

	echo 'Item removed from cart';
	
?>