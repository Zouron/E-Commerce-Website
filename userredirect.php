<?php
	//This page is used to on pages that is only accessible to staff members.
	session_start();
	if(!isset($_SESSION["id"]))
	{
		header("location: login.php");
		return;
	}
	else if($_SESSION["type"]!=1)
	{
		header("location: index.php");
		return;
	}

?>