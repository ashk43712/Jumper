<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php
	
	// logout user
	$_SESSION["userNo"] = null;
	$_SESSION["username"] = null;
	$_SESSION["userDesig"] = null;
	$_SESSION["userSection"] = null;
	$_SESSION["userGroup"] = null;
	$_SESSION["auth"] = null;
	redirect_to("loginpage.php");
	
?>
