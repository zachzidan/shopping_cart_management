<?php
	require_once("common_db.php");
	
	$username = "armaan";
	$pw = password_hash("password", PASSWORD_DEFAULT);
	$email = "test@test.com.au";
	$phone = "0123456789";
	$shopperGroup = "1";
	
	$query = "INSERT INTO `store`.`shopper` (`sh_username`, `sh_password`, `sh_email`, `sh_phone`, `sh_shopgrp`) VALUES ('$username', '$pw', '$email', '$phone', '$shopperGroup')";
	$dbo = db_connect();
	try {
		$statement = $dbo->prepare($query);
		$success = $statement->execute(array());
		echo "User Added";
	}
	catch (PDOException $ex) {
		error_log($ex->getMessage());
		die($ex->getMessage());
	}
?>