<?php

require_once("./common_db.php");
require_once("./session.php");
require_once("./login.php");

logout();
//remove all session variables
session_unset();
//destroy the session
session_destroy();
if(isset($_GET['continue']))
	header('Location: ' . $_GET['continue']);
else
	header('Location: main.php');
?>