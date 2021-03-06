<?php include("../includes/sessions.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
?>
<?php
	require_once("../includes/validation_functions.php");
	if(!isset($_GET["jumperid"]))
		redirect_to("search.php");
	else {
		global $connection;
		$query2 = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} " ;
		$result2 = mysqli_query($connection, $query2);
		if(!$result2)
			die("database failed at layout2_edit_safety form starting.".mysqli_error($conncetion));
		$row2 = mysqli_fetch_assoc($result2);
	}
	if(!check_auth("4") && !check_auth("3")) {
		$_SESSION["message"] = "Not Authorised To CS/SD Approve Jumper";
		$_SESSION["message_color"] = "red";
		if(isset($_GET["jumperid"]))
			redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
		else
			redirect_to("search.php");
	}
	if(isset($_POST["cssd_app_jumper"])) {
		if(!isset($row2["vcApprovedby"])) {
			$_SESSION["message"] = "CS/SD Approval only, after Approval.";
			$_SESSION["message_color"] = "red";
			redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
		}
		//update the database
		if($_POST["tphone_approv_cs"] !== "Y" && $_POST["tphone_approv_sd"] !== "Y") {
			if(!check_auth("4")) {
				$_SESSION["message"] = "Not Authorised To CS/SD Approve Jumper Without CS/SD";
				$_SESSION["message_color"] = "red";
				if(isset($_GET["jumperid"]))
					redirect_to("layout2_edit_safety.php?jumperid={$_GET["jumperid"]}");
				else
					redirect_to("search.php");
			}
		}
		else {
			if(!check_auth("3")) {
				$_SESSION["message"] = "Not Authorised To CS/SD Approve Jumper With CS/SD";
				$_SESSION["message_color"] = "red";
				if(isset($_GET["jumperid"]))
					redirect_to("layout2_edit_safety.php?jumperid={$_GET["jumperid"]}");
				else
					redirect_to("search.php");
			}
		}
		global $connection;
		$date = date('Y-m-d H:i:s');
		$query = "update jumperdr set ";
		$query .= "vcCSSD = '{$_SESSION["username"]}', ";
		$query .= "vcCSSDDesig = '{$_SESSION["userDesig"]}', ";
		$query .= "vcCSSDSection = '{$_SESSION["userSection"]}', ";
		$query .= "vcCSSDDate = '{$date}', ";
		$query .= "chCS = '{$_POST["tphone_approv_cs"]}', ";
		$query .= "chSD = '{$_POST["tphone_approv_sd"]}' ";
		$query .= "where intJumperID = {$_GET["jumperid"]}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		$_SESSION["message"] = "Successfully Approved CS/SD Data";
		$_SESSION["message_color"] = "green";
		redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
	}
?>
<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Jumper Details</a></li>
			<li><a href="layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button special">Approval</a></li>
			<li><a href="layout3.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class="button">Issue</a></li>
			<li><a href="search.php" class="button">Search</a></li>
		</ul>
	</div>
</section>
</header>
<!-- Main -->
<article id="main">
	<section class="wrapper style5">
		<div class = "container-body">
			<div class="inner">
				<?php echo message(); ?>
				<?php echo form_errors(error_messages()); ?>
				<section>
					<form method="post" action=<?php echo "layout2_edit_safety.php?jumperid={$_GET["jumperid"]}"; ?> >
						<?php 
							if(!isset($_GET["jumperid"]))
								redirect_to("search.php");
						?>
						<?php
							if(check_auth("3")) {
						?>
						<h4>Telephonic Approval :</h4>
						<div class = "row uniform">
							<div class="3u 12u$(xsmall)">
								<input type="checkbox" id="tphone_approv_cs" name="tphone_approv_cs" value = "Y" >
								<label for="tphone_approv_cs">CS</label>
							</div>
							<div class="6u 12u$(xsmall)">
								<input type="checkbox" id="tphone_approv_sd" name="tphone_approv_sd" value = "Y">
								<label for="tphone_approv_sd">SD</label>
							</div>
						</div>
						<?php } ?>
						<div class = "row uniform">
							<ul class="actions">
								<li><input type="submit" name = "cssd_app_jumper" value="Approve" class="special" /></li>
								<li ><a href = "layout2.php<?php if(isset($_GET["jumperid"])) echo "?jumperid={$_GET["jumperid"]}"; ?>" class = "button">Cancel</a></li>
							</ul>
						</div>
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
