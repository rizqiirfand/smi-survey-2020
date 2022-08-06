<?php
	if (!session_id()) {
		session_start();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="../css/style-navbar.css">
	<link rel="stylesheet" href="../css/css/all.css">
</head>
<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-sm bg-dark-nav justify-content-between pr-5 p-0 sticky-top">
	<!-- LOGO -->
		<a class="navbar-brand" href="#">
			<img src="../img/logo.gif" alt="Logo" class="logo brightness">
		</a>
	<!-- Login Button -->
		<div class="justify-content-between">
			
			<a href="../logout.php" class="btn btn-dark font-Lato-Black">Logout</a>	      
		</div>
			
	</nav>