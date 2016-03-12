<?php
	require_once("./config.php");
	// First, include the common database access functions, if they're not already included
	require_once("./common_db.php");
	require_once("./session.php");
	require_once("./login.php");
	include("./checkStock.php");
	include("./getSubtotal.php");
	
	include("header.php");
	
	//gets order product in cart
	function retrieveOrderProducts(){
		//check if cart exists in session
		if(!isset($_SESSION['Order_id'])){
			return null;
		}
		$query = "SELECT orderproduct.OP_id, product.prod_img_url, product.prod_desc, orderproduct.OP_prod_id, orderproduct.OP_qty, prodprices.PrPr_Price";
		$query .= " FROM orderproduct, product, prodprices";
		$query .= " WHERE orderproduct.OP_prod_id = product.prod_id AND";
		$query .= " orderproduct.OP_prod_id = prodprices.PrPr_prod_id AND";
		$query .= " product.prod_id = prodprices.PrPr_prod_id AND";
		$query .= " OP_Order_id = ?";
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
				array_push($orderProducts,array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]));
			}
			return $orderProducts;
		}
	}
	
	//retrieves attributes for the corresponding orderproduct
	function retrieveAttributeValues($OP_id){
		$query = "SELECT attribute.name, attributevalue.AttrVal_Value";
		$query .= " FROM attributevalue, orderproductattributevalues, attribute";
		$query .= " WHERE orderproductattributevalues.OPAttr_AttrVal_id = attributevalue.AttrVal_id AND";
		$query .= " attributevalue.AttrVal_Attr_id = orderproductattributevalues.OPAttr_Attr_id AND";
		$query .= " attributevalue.AttrVal_Attr_id = attribute.id AND";
		$query .= " attribute.id = orderproductattributevalues.OPAttr_Attr_id AND";
		$query .= " orderproductattributevalues.OPAttr_OP_id = ?";
		$dbo = db_connect();
		$statement = $dbo->prepare($query);
		$statement->execute(array($OP_id));
		//check if there is any attributes
		if ($statement->rowCount()==0) {
			return null;
		}
		//if there is attributes
		else{
			//generate array of attributes
			$attributes = array();
			while($row = $statement->fetch()){
				array_push($attributes,array($row[0], $row[1]));
			}
			return $attributes;
		}
	}
?>
<div id="main">
	<div class='container'>
		<h1>Shopping Cart</h1>
		<div> 
<?php
	
	//used to generate information to show in shopping cart
	echo "<table class='table'>";
	$OP = retrieveOrderProducts();
	//run only if retrieveOrderProducts returns an array of items
	if($OP != null){
		$prodTotal = getOrderSubtotal();
		//display table headers
		echo "<thead><tr><th class='col-sm-2'>Product</th><th class='col-sm-5'>Details</th><th class:'col-sm-1'>Availability</th><th class='col-sm-1 text-right'>Unit Price</th><th class='col-sm-2 text-right'>Quantity</th><th class='col-sm-1 text-right'>Total</th><th class='col-sm-1'></th></tr></thead>";
		//loop through each row and display them
		for($row=0;$row<count($OP);$row++){
			//retrieves item attributes applied to specified orderproduct
			$attrVal = retrieveAttributeValues($OP[$row][0]);
			echo "<tr>";
			//nest form around table data to allow user to update/remove corresponding item
			echo "<form class='productDisplay' id='form'".$OP[$row][0]."'>
						<input type='hidden' value='".$OP[$row][0]."' name='OP_id'></input>";
			//display image for item
			echo "<td><img class='img img-responsive' width='100' height='100' src='".$OP[$row][1]."'></img></td>";
			//display item name
			echo "<td><h4><a href='DisplayProduct.php?prod_id=".$OP[$row][3]."'>".$OP[$row][2]."</a></h4>";
			//check if attribute is empty
			if($attrVal==null){
				echo "None";
			}
			else{
				//display attributes
				echo "<ul class='circle'>";
				for($i=0;$i<count($attrVal);$i++){
						echo "<li>".$attrVal[$i][0].": ".$attrVal[$i][1]."</li>";
				}
				echo "</ul>";
			}
			//display the product number
			echo "<span class='small'>Product Number: ".$OP[$row][3]."</span></td>";
			//display if stock is available
			echo "<td>".checkStock($OP[$row][3])."</td>";
			//display unit price
			echo "<td class='price' text-right'>$".$OP[$row][5]."</td>";
			//display quantity
			echo "<td><input class='quantity right' type='number' min='1' max='99' name='quantity' onChange='ChangeQuantity(".$OP[$row][0].", value)' value='".$OP[$row][4]."'></td>";
			//display total price
			echo "<td class='price' text-right'>$".$OP[$row][5]*$OP[$row][4]."</td>";
			//display remove button
			echo "<td><a class='close' aria-label='close' id='remove_item_n' data-dismiss='alert' value=".$OP[$row][0]." name='remove' onclick='RemoveFromCart(".$OP[$row][0]."); return false'>x</a></td>";
			echo "</form>";
			echo "</tr>";
		}
		//display cart product total
		echo "<tfoot><tr><td></td><td></td><td></td><td></td><td class='text-right'><strong>Cart Total</strong><br><span class='small'>(excluding tax and shipping)</span></td><td class='price text-right'>$".$prodTotal."</td><td></td></tr></tfoot></table>";
		echo "<div class='row'>";
		echo "<div class='col-sm-9'><a href='DisplayCategory.php'><button type='button' class='btn btn-default shopping'>Continue Shopping</button></a></div>";
		echo "<div class='col-sm-3'><button type='button' class='btn btn-primary checkout'>Go to Checkout</button></div></div>";
		}
	//if cart does not have any items
	else{
		echo "Your cart is empty<br><br>";
		echo "<div class='row'>";
		echo "<div class='col-sm-9'><a href='DisplayCategory.php'><button type='button' class='btn btn-default shopping'>Continue Shopping</button></a></div>";
		echo "<div class='col-sm-3'></div></div>";
	};

?>
		</div>
	</div>
</div>

<?php include "footer.php"; ?> <!-- calls the footer doc and appends at end of page -->