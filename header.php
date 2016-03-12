<!DOCTYPE html>
<?php include("config.php");?>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title><?php echo $store_name." - ".$slogan?></title>
		
		<!-- Calls to style sheets, since header is always called you dont have to call the css again on other php-->
		<LINK rel="stylesheet" type="text/css" href="CSS/layout.css">
		<LINK rel="stylesheet" type="text/css" HREF="CSS/store.css">
		<link href="CSS/bootstrap.min.css" rel="stylesheet">
		<LINK rel="stylesheet" type="text/css" HREF="CSS/great-yuan.css">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="JavaScript/shoppingCartManagement.js" type="text/javascript"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<link href='https://fonts.googleapis.com/css?family=Poiret+One|Crafty+Girls' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Passion+One:700|Raleway' rel='stylesheet' type='text/css'>
		<!-- I don't think we need CDN -Fran -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		
	</head>
	<body>	
		<div class="row">
			<!-- Creates a black navbar which is fixed to the top-->
			<div class="navbar navbar-inverse navbar-fixed-top navbar-left" role="navigation">
			<!-- A container for the content so it doesnt break the div-->
				<div class="container">
				<!-- A button size logo which consists of the shop name -->
					<div class="navbar-header">
					<!-- Hamburger menu for small viewports -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand passion" href="main.php"><?php echo $store_name;?></a>
					</div>
					<!-- Self collapsing bar which switches between a collapsed mode for mobile and a mode for computer. In this case changing from horizontal to stacked mode-->
					<div id="navbar" class="collapse navbar-collapse">'
						<!-- navbar floating cart-->
						<div class='col-md-1 navbar-right'>
							<a id="cartButton" onmouseover="showFloatingCart(this)" class="navbar-brand " href="DisplayShoppingCart.php">Cart</a>
						</div> <!-- floating cart close-->
						<?php include "menu.php"; ?> <!-- calls the specific menu for shopping cart -->					
					</div>
				</div>  
			</div> 
		</div>
		<div onblur="hideFloatingCart(this)" onmouseleave="hideFloatingCart(this)" onmouseenter="showFloatingCart('new')" id='floatingCart'>] 
		</div><!--/.navigation -->
	</body>
</html>