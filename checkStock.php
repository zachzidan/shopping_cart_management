<?php
	require_once("./config.php");
	// First, include the common database access functions, if they're not already included
	require_once("./common_db.php");

	function checkStock($prod_id){
		
		//query to check whether an item is in stock
		$query = "SELECT stock_qty
					FROM stock
					WHERE stock_prod_id = ?";
					
		$dbo = db_connect();
		$statement = $dbo->prepare($query);
		$statement->execute(array($prod_id));
		$row = $statement->fetch();
		
		//check if there are any items in stock and return a statement on availability
		if ($statement->rowCount()==0) {
			return "Item not Available";
		}
		if($row[0] == 0){
			return "Out of Stock";
		}
		elseif($row[0] <  10){
			return "Limited Stock";
		}
		else{
			return "Stock Available";
		}
	}
?>