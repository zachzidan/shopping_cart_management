<?php
require_once("./config.php");
// First, include the common database access functions, if they're not already included
require_once("./common_db.php");
require_once("./session.php");
require_once("./login.php");
?>
<HTML>
<HEAD>
<title><?php echo $store_name; ?> - Catalogue</title>
</HEAD>
<BODY>
<?php include("header.php"); ?>
	<div id="main">
	<div class="col-md-2">
	</div>
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-7 '> 
			<!-- center div where the catalogue stuff will go -->
			<h1> igula. Mauris blandi</h1>
				Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur arcu er<br>
				accumsan id imperdiet et, porttitor at sem. Sed porttitor lectus nibh. Vestibulum ante ipsum primis<br>
 				in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliqu<br>
 				vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitu<br>
				 aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem<br>
				ipscidunt nibiquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem <br>
				ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet elit, eget tincidunt nib<br>				
				pulvinar a. Curabitur arcu erat, accumsan id impssa, convallis a pellentesque nec, egestas non nisi. Curabitur arc <br>
				 in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam<br>
				 vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabit<br>
				 aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lore<br>
				ipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet elit, eget tncidunt ni<br>
				pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem	Praesent sum prim<br>
				 in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliqua<br>
				 vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur<br>
				 aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lore<br>
				vipsum dolor sit amet, consectetur adipiscing elit. Mauris blandit aliquet elit, eget tincidunt nibh<br>
				pulvinar a. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem<br>
	
 			 </div>
  		</div>
		
	</div>
</div>
	
<?php include "footer.php"; ?> <!-- calls the footer doc and appends at end of page -->