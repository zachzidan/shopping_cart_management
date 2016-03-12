<?php
require_once("./config.php");
// First, include the common database access functions, if they're not already included
require_once("./common_db.php");
require_once("./session.php");
require_once("./login.php");
?>

<HTML>
<HEAD>
<TITLE> <?php echo $store_name; ?> - Product</TITLE>
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
 $query = "SELECT prod_name, prod_desc, prod_long_desc, prod_img_url";
 $query1 = "SELECT Attribute.id AS ID, Attribute.name AS Name, AttributeValue.AttrVal_id, AttributeValue.AttrVal_Value AS Value";
 # Append to the $query string - note the required space
 $query .= " FROM Product";
 $query1 .= " FROM Attribute, AttributeValue";
 # If a category name has been provided, then add a WHERE clause
    if(isset($_GET["prod_id"])) {
     $prod_id = $_GET["prod_id"];
    }
 $query .= " WHERE prod_id = $prod_id"; 
 $query1 .= " WHERE Attribute.Product_prod_id = $prod_id AND AttributeValue.AttrVal_Prod_id = $prod_id AND AttributeValue.AttrVal_Prod_id = Attribute.Product_prod_id AND Attribute.id = AttributeValue.AttrVal_Attr_id";
    # Order by name then by AttrVal_Value
 $query1 .= " ORDER BY Attribute.name, AttributeValue.AttrVal_Value";
 # Run the query, returning a PDOStatement object - see http://www.php.net/manual/en/class.pdostatement.php
 # Notice, this statement will throw a PDOException object if any problems - see http://www.php.net/manual/en/class.pdoexception.php
 # There's another thing wrong with this query which we'll look at when we discuss SQL injection
 try {
  $statement = $dbo->query($query);
  $statement1 = $dbo->query($query1);
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
			<!-- center div where the catalogue stuff will go -->
<!-- Mixed-up HTML and embedded bits of PHP from here on; read the tags carefully -->
<!-- Print the table headers, with 2px borders around cells so you can see the structure -->
<TABLE BORDER= 1>
<TR>
<?php
 # Print the rest of the table
 # fetch() returns an array (by default, both indexed and name-associated) of result values for the row
    $row = $statement->fetch(PDO::FETCH_ASSOC)?> <!-- see http://www.php.net/manual/en/pdostatement.fetch.php -->
 <td><?php echo "<img src='".$row['prod_img_url']."' width='150' height='150'></img>"?></td>
 <td>
 <table border=1>

  <TR><TH><?php echo $row['prod_name'];?></TH></TR>
  <TR><TD><?php echo $row['prod_desc'];?></TD><TR>
  <TR><TD><?php echo $row['prod_long_desc'];?></TD></TR>
  <tr><td> <form id="PRODUCT_ID" onsubmit="AddToCart(); return false">
   <input type="hidden" value="<?php echo $prod_id;?>" name="prod_id"></input>
   <table><tr><td>Quantity:</td><td><select name='quantity'>
		<option selected value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10'>10</option>
   </select></td></tr>
   <?php
   #insert any attibutes if applicable
   $attr_id = null;
   while($row1 = $statement1->fetch(PDO::FETCH_ASSOC)){
    #need to close select after each attribute
    if($attr_id != $row1['ID']){
     if($attr_id != null){
      echo "</select></td></tr>";
     }
     echo "<tr><td>".$row1['Name'].":</td><td><select  class='attributes' onchange='disabledButton()' name='AttrVal_id[]'>";
	 echo "<option  selected disabled hidden value='0'>Select</option>";
     $attr_id = $row1['ID'];
    }
    echo "<option value='".$row1['AttrVal_id']."'>".$row1['Value']."</option>";
   }
   #to close off select after last row has been read
   if($attr_id != null){
    echo "</select></td></tr><table>";
   }
   ?>
   <input type="submit" id="addToCartButton" value="Add to Cart"></input>
  </form></td></tr>
<?php
 # Drop the reference to the database
 $dbo = null;
?>
</table>
</td>
</TR>
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