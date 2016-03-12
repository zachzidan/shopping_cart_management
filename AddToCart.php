<?php
	// First, include the common database access functions, if they're not already included
	require_once("./common_db.php");
	require_once("./session.php");
	require_once("./config.php");
	include("./calculateSubtotal.php");
	include("./updateProductAmount.php");
	
	$order_id = $product_id = $attribute = $qty = null;
	//checks if user is logged in
	$shopper_id = getShopperId();
	//when user not logged in, assign guest shopper_id
	if($shopper_id == 0){
		$shopper_id = $guestShopper;
	}
	$dbo = db_connect();
	//check if the user has a cart existing
	if(!isset($_SESSION['Order_id'])){
		$query = "INSERT INTO store.order (Order_Shopper, Order_shaddr, Order_TimeStamp, Order_PaymentAuthorized, Order_ProductAmount)";
		$query .= " VALUES ('$shopper_id', '$guestAddress', NOW(), 0, 0)";
		$statement = $dbo->prepare($query);
		$statement->execute();
		//get last insert id
		$order_id = $_SESSION['Order_id'] = $dbo->lastInsertId();
	}
	else{
		$order_id = $_SESSION['Order_id'];
	}
	//get values entered on product page
	$product_id = $_GET['prod_id'];
	$attrVal_id = $_GET['AttrVal_id'];
	$qty = $_GET['quantity'];
	//check if the product with same attributes exists
	$query = "SELECT orderproduct.OP_id, orderproduct.OP_qty, orderproductattributevalues.OPAttr_AttrVal_id FROM orderproduct, orderproductattributevalues";
	$query .= " WHERE orderproduct.OP_id = orderproductattributevalues.OPAttr_OP_id AND";
	$query .= " orderproduct.OP_Order_id = '$order_id' AND";
	$query .= " orderproduct.OP_prod_id = '$product_id'";
	$query .= " ORDER BY OP_id, OPAttr_AttrVal_id ASC";
	$statement = $dbo->prepare($query);
	$statement->execute();
	//preparation to check if the attributes selected already exist in the cart
	$attrMatches = false;
	$quantity = 0;
	$OP_id = null;
	//if the product is currently in the cart
	//check to see if the attributes match
	if($statement->rowCount() > 0){
		while($row=$statement->fetch()){
			//check if the orderproduct id has changed
			if($OP_id!=$row[0]){
				//check if the attributes match then proceed to update
				if($OP_id != null AND $attrMatches == true){
					break;
				}
				//otherwise reset variables
				$attrMatches = true;
				$OP_id = $row[0];
			}
			//check if the attributes match for this orderproduct entry
			if($attrMatches == false){
				continue;
			}
			for($i=0;$i<count($attrVal_id);$i++){
				//check if the attribute selected and in the database match
				if($row[2]==$attrVal_id[$i]){
					$attrMatches = true;
					$quantity = $row[1];
					//if they do, you dont need to check the next attribute if applicable
					break;
				}
				//otherwise it doesnt match
				$attrMatches = false;
			}
		}
	}	
	//when the user adds the same item with the same attributes
	//update the quantity
	if($attrMatches == true){
		//update quantity
		$qty = $quantity+$qty;
		$query = "UPDATE orderproduct SET OP_qty = '$qty' WHERE OP_id = '$OP_id'";
		$statement = $dbo->prepare($query);
		$statement->execute();
	}
	//otherwise add a new row in orderproduct
	else{
		//insert item into orderproduct table
		$query = "INSERT INTO orderproduct (OP_prod_id, OP_Order_id, OP_qty)";
		$query .= " VALUES ('$product_id', '$order_id', '$qty')";
		$statement = $dbo->prepare($query);
		$statement->execute();
		//get last insert id
		$OP_id = $dbo->lastInsertId();
		//insert attributes into orderproductattributevalues
		for($row = 0; $row<count($attrVal_id); $row++){
			$temp = $attrVal_id[$row];
			$query = "INSERT INTO orderproductattributevalues (OPAttr_OP_id, OPAttr_Attr_id, OPAttr_AttrVal_id)";
			$query .= " VALUES ('$OP_id', (SELECT AttrVal_Attr_id FROM attributevalue WHERE AttrVal_id = '$temp'), '$temp')";
			$statement = $dbo->prepare($query);
			$statement->execute();
		}
	}
	//update timestamp and subtotal on cart
	updateProductAmount(calculateOrderSubtotal(), $order_id);
	
	echo "Item Added to Cart";
?>