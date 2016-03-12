<?php
	require_once("./common_db.php");
	require_once("./session.php");
	
	
	//Calculates the subtotal of the cart and returns the value
	function calculateOrderSubtotal(){
		if(isset($_SESSION['Order_id'])){
			$query = "SELECT  orderproduct.OP_qty, prodprices.PrPr_Price";
			$query .= " FROM orderproduct, prodprices";
			$query .= " WHERE orderproduct.OP_prod_id = prodprices.PrPr_prod_id";
			$query .= " AND OP_Order_id = ?";
			$dbo = db_connect();
			$statement = $dbo->prepare($query);
			$statement->execute(array($_SESSION['Order_id']));
			$prodTotal = 0;
			while($row = $statement->fetch()){
				$prodTotal += $row[0]*$row[1];
			}
			return $prodTotal;
		}
		return 0;
	}
?>