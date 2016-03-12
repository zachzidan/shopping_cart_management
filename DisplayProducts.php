<?php
require_once("./config.php");
// First, include the common database access functions, if they're not already included
require_once("./common_db.php");
require_once("./session.php");
require_once("./login.php");
?>

<HTML>
<HEAD>
<TITLE> <?php echo $store_name; ?> - Products</TITLE>
</HEAD>
<BODY>
<?php include "header.php"; ?>
<div id="main">
<div class="col-md-2">
</div>
<!-- Variables are returned as $_GET["varname"] or $_POST["varname"] -->
<!--  Notice that the "<?= expression ?>" nugget to print an expression in the middle of HTML -->
<!--  won't work on all versions or installs of PHP and you may have to -->
<!--  use "<?php echo expression ?>" instead -->

<?php
	// PHP/C++-style comments inside the PHP code
	# Get a PDO database connection - see http://www.php.net/manual/en/book.pdo.php
	$dbo = db_connect();
	# Construct an SQL query as multiple lines for readability
	$query = "SELECT Product.prod_id, Product.prod_name AS Product, Product.prod_desc AS Description, Product.prod_disp_cmd";
	# Append to the $query string - note the required space
	$query .= " FROM Product, CgPrRel";
	$cat_id = 1;
	# If a category id has been provided, set the category id for WHERE clause
    if (isset($_GET["cat_id"])) {
    	$cat_id = $_GET["cat_id"];
    }
	$query .= " WHERE Product.prod_id = CgPrRel.cgPr_prod_id AND CgPr_cat_id = $cat_id";
    # Sort on category name, not ID
    $query .= " ORDER BY Product.prod_name";

	# Run the query, returning a PDOStatement object - see http://www.php.net/manual/en/class.pdostatement.php
	# Notice, this statement will throw a PDOException object if any problems - see http://www.php.net/manual/en/class.pdoexception.php
	# There's another thing wrong with this query which we'll look at when we discuss SQL injection
	try {
		$statement = $dbo->query($query);
	}
	# Provide the exception handler - in this case, just print an error message and die,
	# but see the provided default exception handler in common_db.php, which logs to the Apache error log
	catch (PDOException $ex) {
		echo $ex->getMessage();
		die ("Invalid query");
	}

?>
<!-- A fluid div which is responsive to the users screen and resizing-->
	<div class='container-fluid'>
	<!-- Creates a div which puts the items in a row when possible-->
		<div class='row'>
			<div class='col-md-7 '> 
<!-- Mixed-up HTML and embedded bits of PHP from here on; read the tags carefully -->
<!-- Print the table headers, with 2px borders around cells so you can see the structure -->
<TABLE BORDER=2>
<TR>
<!-- First, print the column headers -->
	<TH>ID</TH>
	<TH>Product</TH>
	<TH>Description</TH>
   </TR>
<?php
	# Print the rest of the table
	# fetch() returns an array (by default, both indexed and name-associated) of result values for the row
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?> <!-- see http://www.php.net/manual/en/pdostatement.fetch.php -->
		<TR>
		    <TD><?php echo $row['prod_id'];?></TD>
			<TD><a href="<?php echo $row['prod_disp_cmd'].'?prod_id='.$row['prod_id'];?>"><?php echo $row['Product'];?></a></TD>
			<TD><?php echo $row['Description'];?></TD>
		</TR>
<?php	}

	# Drop the reference to the database
	$dbo = null;
?>
</TABLE>
</div>
</div>
</div>
</div>
<div id="footer">
<?php include("footer.php"); ?>
</div>
</BODY>
</HTML>
