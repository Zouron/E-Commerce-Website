<?php
//This page redirects non-registers visitors to the login page
if(!isset($_SESSION["id"]))
	{
		header("location: login.php");
		return;
	}
?>