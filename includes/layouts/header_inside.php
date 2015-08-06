<?php 
	ob_start();
?>
<!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Jumper - KKNPP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script src="assets/js/ie/html5shiv.js"></script>
		<link rel="stylesheet" href="assets/css/jquery-ui.css" />
		<link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/ie8.css" />
		<link rel="stylesheet" href="assets/css/ie9.css" />
	</head>
	<body>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="homepage.php">Jumper</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span><?php if(isset($_SESSION["userNo"])) echo "{$_SESSION["userNo"]}"; else echo "Menu";?></span></a>
									<div id="menu">
										<ul><li><a href="homepage.php">Home</a></li>
											<li><a href="layout1.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>">Jumper Details</a></li>
											<li><a href="layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>">Approved By</a></li>
											<li><a href="layout3.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>">Issued</a></li>
											<li><a href="logout.php">Log Out</a></li>
											<li><a href="search.php">Search</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
