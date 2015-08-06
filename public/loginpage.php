<?php include("../includes/sessions.php");?>
<?php require_once("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php
	require_once("../includes/validation_functions.php");
	if(isset($_POST["login_submit"])) {
		//check login
		if(check_login($_POST["username"], $_POST["password"])) {
			redirect_to("search.php");
		}			
		else {
			$_SESSION["message"] = "Invalid/Username Password";
			redirect_to("loginpage.php");
		}
	}
?>
<!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Jumper Maintenance</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script src="assets/js/ie/html5shiv.js"></script>
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/ie8.css" />
		<link rel="stylesheet" href="assets/css/ie9.css" />
	</head>
	<body class="landing">

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header" class="alt">
						<h1><a href="homepage.html">JUMPER</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="homepage.php">Home</a></li>
											<li><a href="layout1.php">Jumper Details</a></li>
											<li><a href="layout2.php">Approved By</a></li>
											<li><a href="layout3.php">Timestamps</a></li>
											<li><a href="loginpage.php">Log In</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Banner -->
					<section id="banner">
						<div class="inner">
							<h2>Jumper</h2>
							<section>
								<center><h4>Login</h4></center>
									<form method="post" action="loginpage.php">
										<div class="inner">
											<center>
												<div class="4u 12u$(xsmall)" align = "center">
													<input type="text" name="username" id="username" value="" placeholder="User Name" />
												</div>
												<br>
												<div class="4u$ 12u$(xsmall)" align = "center">
													<input type="password" name="password" id="password" value="" placeholder="Password" />
												</div>
											</center>
											<br>
											<div class="12u$">
												<ul class="actions">
													<li><input type="submit" name = "login_submit" value="Submit" class="special" /></li>
												</ul>
											</div>
										</div>
								</section>
							</form>
							<?php echo message(); ?>
							<?php echo form_errors(error_messages()); ?>
						</div>
					</section>

				<!-- Footer -->
					<footer id="footer">
						<ul class="copyright">
							<li>&copy; <a href = "http://www.npcil.nic.in/" target = "blank">KKNPP</a></li><li>Design: <a href="http://www.bits-pilani.ac.in" target = "blank">BITS, Pilani</a></li>
						</ul>
					</footer>

			</div>
		
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/ie/respond.min.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
