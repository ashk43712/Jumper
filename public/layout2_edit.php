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
		$query2 = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
		$result2 = mysqli_query($connection, $query2);
		if(!$result2)
			die("database failed at layou1_edit form starting.".mysqli_error($connection));
		$row2 = mysqli_fetch_assoc($result2);
	}
	if(!check_auth("3")) {
		$_SESSION["message"] = "Not Authorised To Approve Or Cancel Jumper";
		$_SESSION["message_color"] = "red";
		if(isset($_GET["jumperid"]))
			redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
		else
			redirect_to("search.php");
	}
	if(isset($_POST["app_jumper"])) {
		if(!has_presence($_POST["valid_upto"])) {
			//mandatory fields are not present
			$_SESSION["error_messages"][] = "All Field Marked * Are Mandatory.";
			redirect_to("layout2_edit.php?jumperid={$_GET["jumperid"]}");
		}
		if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST["valid_upto"])) {
			//mandatory fields are not present
			$_SESSION["error_messages"][] = "PLease Enter Valid Date";
			redirect_to("layout2_edit.php?jumperid={$_GET["jumperid"]}");
		}
		if(!($row2["vcStatus"] == "NEW")) {
			$_SESSION["message"] = "Approval can be given only once, to a New Jumper.";
			$_SESSION["message_color"] = "red";
			redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
		}
		//update the database
		global $connection;
		$date = date('Y-m-d H:i:s');
		$query = "update jumperdr set ";
		$query .= "vcApprovedby = '{$_SESSION["username"]}', ";
		$query .= "vcApprovedbyDesig = '{$_SESSION["userDesig"]}', ";
		$query .= "vcApprovedbySection = '{$_SESSION["userSection"]}', ";
		$query .= "vcApprovedbyDate = '{$date}', ";
		$query .= "vcApprovedTill = '{$_POST["valid_upto"]}', ";
		$query .= "chCategory = '{$_POST["create_radio"]}', ";
		$query .= "chJASS = '{$_POST["jumper_ass"]}', ";
		$query .= "chReqFuncTest = '{$_POST["req_func_test"]}', ";
		$query .= "chCancel = \"N\", ";
		$query .= "vcStatus = 'APP' ";
		$query .= "where intJumperID = {$_GET["jumperid"]}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		set_jumperno($_GET["jumperid"] , $_POST["create_radio"]);
		$_SESSION["message"] = "Successfully Approved Jumper";
		$_SESSION["message_color"] = "green";
		redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
	}
	else if(isset($_POST["cancel_jumper"])) {
		if(!($row2["vcStatus"] == "NEW")) {
			$_SESSION["message"] = "Cancellation can be done only once, to a New Jumper.";
			$_SESSION["message_color"] = "red";
			redirect_to("layout2.php?jumperid={$_GET["jumperid"]}");
		}
		//update the database
		global $connection;
		$date = date('Y-m-d H:i:s');
		$query = "update jumperdr set ";
		$query .= "vcApprovedby = '{$_SESSION["username"]}', ";
		$query .= "vcApprovedbyDesig = '{$_SESSION["userDesig"]}', ";
		$query .= "vcApprovedbySection = '{$_SESSION["userSection"]}', ";
		$query .= "vcApprovedbyDate = '{$date}', ";
		$query .= "vcApprovedTill = '{$_POST["valid_upto"]}', ";
		$query .= "chCategory = '{$_POST["create_radio"]}', ";
		$query .= "chJASS = '{$_POST["jumper_ass"]}', ";
		$query .= "chReqFuncTest = '{$_POST["req_func_test"]}', ";
		$query .= "chCancel = \"Y\", ";
		$query .= "vcStatus = 'CAN' ";
		$query .= "where intJumperID = {$_GET["jumperid"]}";
		$result = mysqli_query($connection, $query);
		if(!$result) {
			die("<br><br>database insert query failed.".mysqli_error($connection));
		}
		set_jumperno($_GET["jumperid"] , $_POST["create_radio"]);
		$_SESSION["message"] = "Successfully Cancelled Jumper";
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
					<form method="post" action=<?php echo "layout2_edit.php?jumperid={$_GET["jumperid"]}";?>>
						<?php
							if(isset($_GET["jumperid"])) {
								$query = "Select * from jumperdr where intJumperID = {$_GET["jumperid"]} limit 1" ;
								$result = mysqli_query($connection, $query);
								if(!$result)
									die("database failed at layou1_edit form starting.".mysqli_error($connection));
								$row = mysqli_fetch_assoc($result);
							}
							else
								redirect_to("search.php");
						?>
						<?php if (!isset($row["chCategory"])) { ?>
							<div class = "row uniform">
								<h4>Category : </h4>
								<div class="1u 12u$(small)">
									<input type="radio" id="create_c" name="create_radio" value = "C" checked>
									<label for="create_c">C</label>
								</div>
								<div class="1u 12u$(small)">
									<input type="radio" id="create_nc" name="create_radio" value = "NC">
									<label for="create_nc">NC</label>
								</div>
							</div>
						<?php } ?>
						<?php if (isset($row["chCategory"])) { ?>
							<div class = "row uniform">
								<h4>Category : </h4>
								<div class="3u 12u$(small)">
									<input type="text" name="create_radio" id="create_radio" <?php if(isset($row["chCategory"])) echo "value =\"".htmlentities($row["chCategory"])."\""; ?> readonly />
								</div>
							</div>
						<?php } ?>
						<div class = "row uniform">
							<h4> Jumper Affect Safety System: </h4>
							<div class="1u 12u$(small)">
								<input type="radio" id = "yes" name="jumper_ass" value = "Y" checked>
								<label for="yes">Yes</label>
							</div>
							<div class="1u 12u$(small)">
								<input type="radio" id = "no" name="jumper_ass" value = "N">
								<label for="no">No</label>
							</div>
						</div>
						<div class = "row uniform">
							<h4>Requirement of func test :</h4>
							<div class="1u 12u$(small)">
								<input type="radio" id="qwerty" name="req_func_test" value = "Y" checked>
								<label for="qwerty">Yes</label>
							</div>
							<div class="1u 12u$(small)">
								<input type="radio" id="qwertn" name="req_func_test" value = "N">
								<label for="qwertn">No</label>
							</div>
						</div>
						<div class = "row uniform">
							<h4>Valid upto <sup><font color = "red">*</font></sup> :</h4>
							<div class="3u 6u$(xsmall)">
								<div class="ui-widget-content form_pad"><input type="text" name="valid_upto" id="valid_upto" <?php if(isset($row["vcApprovedTill"]) && $row["chCancel"] == "N") echo "value =\"".htmlentities($row["vcApprovedTill"])."\""; ?> placeholder = "YYYY-MM-DD" /></div>
							</div>
						</div>
						<div class = "row uniform">
							<ul class="actions">
								<li><input type="submit" name = "app_jumper" value="Approve/Rec" class="special" /></li>
							</ul>
							<ul class="actions">
								<li><input type="submit" name = "cancel_jumper" value="Cancel Jumper" /></li>
							</ul>
						</div>
						
					</form>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
