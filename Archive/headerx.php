<html>
	<head>
		<!-- Calls to style sheets, since header is always called you dont have to call the css again on other php-->
		<LINK rel="stylesheet" type="text/css" href="CSS/layout.css">
		<LINK rel="stylesheet" type="text/css" HREF="CSS/store.css">
		<LINK rel="stylesheet" type="text/css" HREF="CSS/great-yuan.css">
		<link href="CSS/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="JavaScript/shoppingCartManagement.js" type="text/javascript"></script>
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
					<!-- The 'logo' since we dont have one and it also links back to main page -->
						<a class="navbar-brand" href="main.php">Super Notebook Store</a>
					</div>
					<!-- Self collapsing bar which switches between a collapsed mode for mobile and a mode for computer. In this case changing from horizontal to stacked mode-->
					<div class="collapse navbar-collapse">'
							<!-- navbar floating cart-->
							<div class='col-md-1 navbar-right'>
								<a id="cartButton" onmouseover="showFloatingCart(this)" class="navbar-brand " href="DisplayShoppingCart.php">Cart</a>
							</div> <!-- floating cart close-->
						
						<!-- Floating cart button which consists of the cart button with required functionality-->
						<!-- Simple form which requires the search function which is yet to be implemented-->	
					</div>
				</div>		  
		  </div> 
	   </div>
 	</div>	
	


</body>

	

