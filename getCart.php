
<?php
	// First, include the common database access functions, if they're not already included
	require_once("./common_db.php");
	//used to get session variable
	require_once("./session.php");
	include("./getSubtotal.php");

	function retrieveOrderProducts(){
		if(!isset($_SESSION['Order_id'])){
			return null;
		}
		$query = "SELECT product.prod_img_url, product.prod_id, product.prod_name, orderproduct.OP_qty, prodprices.PrPr_Price";
		$query .= " FROM orderproduct, product, prodprices";
		$query .= " WHERE orderproduct.OP_prod_id = product.prod_id AND orderproduct.OP_prod_id = prodprices.PrPr_prod_id AND product.prod_id = prodprices.PrPr_prod_id";
		$query .= " AND OP_Order_id = ?";

		$dbo = db_connect();
		$statement = $dbo->prepare($query);
		$statement->execute(array($_SESSION['Order_id']));
		//check if there is an existing cart
		if ($statement->rowCount()==0) {
			return null;
		}
		//if there is a cart item
		else{
			//generate array of items to show in floating cart
			$orderProducts = array();
			while($row = $statement->fetch()){
				array_push($orderProducts,array($row[0],$row[1],$row[2],$row[3],$row[4]));
			}
			return $orderProducts;
		}
	}
	#new
	//used to generate information to show in shopping cart
	echo "<div id='floatmain'> <div class='panel panel-default' style='
    margin-bottom: 0px;'>
    <div class='panel-body'><table id='floatingCartTable'>";
	$OP = retrieveOrderProducts();
	//if cart has items
	if($OP != null){
		$prodTotal = getOrderSubtotal();
		for($row=0;$row<count($OP);$row++){
			echo "<tr>";
			//display image
			echo "<td style='padding-right: 35px;'><a href='./DisplayProduct.php?prod_id=".$OP[$row][1]."'><img width='75' height='75' src='".$OP[$row][0]."'></img></a></td>";
			//display product name and provides link to product page
			echo "<td><a href='./DisplayProduct.php?prod_id=".$OP[$row][1]."'>".$OP[$row][2]."</a>";
			//show quantity
			echo "<br><br>Qty: ".$OP[$row][3]."</td>";
			//show price
			echo "<td>$".$OP[$row][4]."</td>";
			echo "</tr>";
		}
		
		echo "<tr><td colspan='3'><b><hr> &nbsp Subtotal = $".$prodTotal."<hr></td></b></tr>".
		"<table id='floatingCartTable' ><div class='btn-group' role='group' aria-label='...'style='margin-left: 80px;'><a href='DisplayShoppingCart.php'><button type='button' class='btn btn-default btn-sm'>View Cart</button></a>
						<a href='main.php'><button type='button' class='btn btn-success btn-sm'> Checkout</button></a></div></table>";
	}
	//if cart does not have any items
	else{
		echo "&nbsp Your cart is empty";
	}
	echo "</table></div>";
?>