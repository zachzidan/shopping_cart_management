<?php 
	require_once("./session.php");

	if(getShopperId()>0){
	 /* left menu. THe items given are ones Les gave us, they can be changed if necessary*/
	echo"      
		<ul class='nav navbar-nav navbar-right'>
			<li><a href='main.php'>Home</a></li>
			<li><a href='displayCategory.php'>Catalogue</a></li>
			<li><a href='logoutshopper.php'>Log Out</a></li>
		</ul>";
		}
		else{
		echo"     
		<ul class='nav navbar-nav navbar-right'>
			<li><a href='main.php'>Home</a></li>
			<li><a href='displayCategory.php'>Catalogue</a></li>
			<li><a href='loginshopper.php'>Log In</a></li>
		</ul>";	
		}
?>
	  