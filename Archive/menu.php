<?php 
	require_once("./session.php");

	if(getShopperId()>0){
	 /* left menu. THe items given are ones Les gave us, they can be changed if necessary*/
	echo"      
		<ul class='nav nav-pills nav-stacked'>
			<li class='active'><a href='main.php'>Home</a></li>
			<li><a href='logoutshopper.php'><b>Log Out</b></a></li>
			<li><a href='displayCategory.php'><b>Catalogue</b></a></li>
			<li><a href='DisplayShoppingCart.php'><b>Cart</b></a></li>
		  </ul>
		 ";
		}
		else{
		echo"     
		<ul class='nav nav-pills nav-stacked'>
			<li class='active'><a href='main.php'>Home</a></li>
			<li><a href='loginshopper.php'><b>Log In</b></a></li>
			<li><a href='displayCategory.php'><b>Catalogue</b></a></li>
			<li><a href='DisplayShoppingCart.php'><b>Cart</b></a></li>
		  </ul>
		 ";	
		}
?>
	  