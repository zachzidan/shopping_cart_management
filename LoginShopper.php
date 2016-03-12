<?php
require_once("./config.php");
require_once("./common_db.php");
require_once("./session.php");
require_once("./login.php");

// Where to go next
if (isset($_GET['continue'])) {
	$continue = $_GET['continue'];
}
else {
	if (isset($_POST['continue'])) {
		$continue = $_POST['continue'];
	}
	else {
		$continue = "DisplayCategory.php";
	}
}

if(isset($_POST['stage']) && ($_POST['stage'] == 'process')) {
	process_form();
} else {
	print_form($continue, "Please enter your account details:");
}

function process_form() {
	global $continue;
	if(login($_POST['username'], $_POST['password'])) {
		header("Location: $continue");
	}
	else {
		print_form($continue, "Invalid credentials");
	}
}

function print_form($continue, $error) {
	global $store_name, $slogan;
	$title = $store_name . " - " . "Shopper Login";
	?>
<html>
<head>
<title><?= $store_name ?> - Shopper Login</title>
</head>
<body>
<?php include "header.php"; ?>
<div id="main">
<div class="col-md-2">
</div>
<!-- A fluid div which is responsive to the users screen and resizing-->
	<div class='container-fluid'>
	<!-- Creates a div which puts the items in a row when possible-->
		<div class='row'>
			<div class='col-md-7 '> 
<h1><?php echo $store_name?> - Shopper Login</h1>
<table border="2">
<form id="login" method="post" onsubmit="return validateFormOnSubmit(this)" action="LoginShopper.php">
<input type="hidden" name = "continue" value = "<?= $continue ?>" />
<input type="hidden" name = "stage" value = "process" />
<table summary="Login form">
  <tbody>
<tr><td colspan="2"> <?php echo $error ?> </td></tr>
<tr>
    <td><label for="username">Your username:</label></td>
    <td><input name="username" size="35" maxlength="50" type="text"/></td>
  </tr>   
  <tr>
    <td><label for="password">Your password:</label></td>
    <td><input name="password" size="35" maxlength="25" type="password"/></td>
    <td>(7 - 15 chars)</td>
  </tr>   
  <tr>
    <td>&nbsp;</td>
    <td><input name="Submit" value="Log In" type="submit"/></td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
</form>
</table>
</div>
</div>
</div>
</div>
<div id="footer">
<?php include("footer.php"); ?>
</div>
</html>
<?php
}	// End of print_form() function
?>
  