<?php

require_once("./common_db.php");
require_once("./session.php");
require_once("./config.php");
include("./calculateSubtotal.php");
include("./updateProductAmount.php");

	$dbo = db_connect();
	$order_id = $_SESSION['Order_id'];
	
	//Checks that an OP_id has been set and instantiates the value
	if(isset ($_POST['OP_id'])) {
		$opid = $_POST['OP_id'];
	}
	else if(isset ($_GET['OP_id'])){
		$opid = $_GET['OP_id'];
	}
	else {
		return null;
	};
	
	//Deletes all rows related to the product being removed
	$query1 = "DELETE FROM orderproductattributevalues
				WHERE OPAttr_OP_id = ?";
				
	$statement1 = $dbo->prepare($query1);
	$statement1->execute(array($opid));
	
	//Deletes the product from the orderproduct table
	$query2 = "DELETE FROM orderproduct 
				WHERE OP_id = ?";
				
	$statement2 = $dbo->prepare($query2);
	$statement2->execute(array($opid));
	
	//Updates the product subtotal and cart subtotal
	updateProductAmount(calculateOrderSubtotal(),$order_id);

	echo 'Item removed from cart';

?>