<?php include("../includes/sessions.php");?>
<?php include("../includes/db_connection.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/layouts/header_inside.php");?>
<?php
	require_once("../includes/validation_functions.php");
	if(!isset($_SESSION["username"])) {
		redirect_to("loginpage.php");
	}
	check_session_timeout();
?>
<?php
	if(isset($_POST["search_submit"])) {
		if(!isset($_POST["options"]) || !isset($_POST["entered"]))
			redirect_to("search.php");
		redirect_to("search_options.php?options={$_POST["options"]}&value={$_POST["entered"]}");
	}
?>

<style>
	.scrollable {
		height: 500px;
		overflow-y: auto;
	}
</style>

<section align = center>
	<div class = "container-header" align = center>
		<ul class="actions">
			<li><a href="layout1_edit.php" class="button">New Jumper</a></li>
			<li><a href="search.php" class="button special">Search</a></li>
			<li><a href="logout.php" class="button">Log Out</a></li>
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
					<form name="chooseForm" id="chooseForm" method="post" action="search.php">
						<div class = "bordered" align = center >
							<h6>Search By:</h6>
							<ul class="actions">
								<li ><a href = "search.php?type=1" class = "button special">DR</a></li>
								<li ><a href = "search.php?type=2" class = "button special">Jumper</a></li>
								<!--<li ><a href = "search.php?type=3" class = "button special">Tag</a></li>-->
								<li ><a href = "search.php?type=4" class = "button special">Date</a></li>
								<li ><a href = "search.php?type=5" class = "button special">Proposed By</a></li>
							</ul>
						</div>
					</form>
					<?php 
						if(isset($_GET["type"]) && $_GET["type"] === "1") {
					?>
							<div align = center >
								<h4>Enter DR No. : </h4>
							</div>
							<form name = "DRForm" id = "DRForm" method = "post" action = "search.php?type=1">
								<div align = center>
									<div class="4u 12u$(xsmall)">
										<input type="text" name="enter_dr" id="enter_dr" placeholder = "Enter DR No." onkeyup="validateNonEmpty(this, document.getElementById('date_help'))" />
											<span id="date_help" class="help"></span>
									</div>
									<br>
									<ul class="actions">
										<li ><input type="submit" name = "go_dr" value="Go!" class="special" /></li>
									</ul>
								</div>
							</form>
					<?php
							if(isset($_POST["go_dr"])&&!empty($_POST["enter_dr"])) {
								//validations
								if(!preg_match("/^[0-9]{1}-[0-9]{2}-[0-9]{2}-[0-9a-zA-Z]{2}-[0-9]{3}$/", $_POST["enter_dr"])) {
									//DR NO. not like 1-15-09-MM-002
									$_SESSION["message"] = "Invalid DR-No.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=1");
								}
								
								
								if($result = get_jumpers_for_dr($_POST["enter_dr"])) {
									echo "<div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>Jumper No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>DR No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Proposed By</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Date</h5></div><div class=\"1u 12u$(xsmall)\"><h5>Stat</h5></div></div></div>";
									echo "<div class=\"scrollable\">";
									while($row = mysqli_fetch_assoc($result)) {
										$date_row = DATE($row["vcProposedbyDate"]);
										echo "<a href = \"layout1.php?jumperid={$row["intJumperID"]}\"><div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>{$row["vcJumperNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcDRNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcProposedby"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$date_row}</h5></div><div class = \"1u 12u$(xsmall)\"><h5>{$row["vcStatus"]}</h5></div></div></div></a>";
									}
									echo "</div>";
								
								}
								else {
									$_SESSION["message"] = "DR-No Not Found.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=1");
								}
							}
						}
					?>
					<?php 
						if(isset($_GET["type"]) && $_GET["type"] === "2") {
					?>
							<div align = center >
								<h4>Enter Jumper No. : </h4>
							</div>
							<form name = "JumperForm" id = "JumperForm" method = "post" action = "search.php?type=2">
								<div align = center>
									<div class="4u 12u$(xsmall)">
										<input type="text" name="enter_jumper" id="enter_jumper" placeholder = "Enter Jumper No." onkeyup="validateNonEmpty(this, document.getElementById('date_help'))" />
											<span id="date_help" class="help"></span>
									</div>
									<br>
									<ul class="actions">
										<li ><input type="submit" name = "go_jumper" value="Go!" class="special" /></li>
									</ul>
								</div>
							</form>
					<?php
							if(isset($_POST["go_jumper"])&&!empty($_POST["enter_jumper"])) {
								//validations
								if(!preg_match("/^[0-9]{1}-[0-9]{2}-[a-zA-Z]{1,2}-[0-9]{3}$/", $_POST["enter_jumper"])) {
									//DR NO. not like 1-15-NC-08
									$_SESSION["message"] = "Invalid Jumper No.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=2");
								}
								
								
								if($result = get_jumpers_for_jumper($_POST["enter_jumper"])) {
									echo "<div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>Jumper No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>DR No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Proposed By</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Date</h5></div><div class=\"1u 12u$(xsmall)\"><h5>Stat</h5></div></div></div>";
									$jumperid = "";
									while($row = mysqli_fetch_assoc($result)) {
										$jumperid = $row["intJumperID"];
										$date_row = DATE($row["vcProposedbyDate"]);
										echo "<a href = \"layout1.php?jumperid={$row["intJumperID"]}\"><div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>{$row["vcJumperNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcDRNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcProposedby"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$date_row}</h5></div><div class = \"1u 12u$(xsmall)\"><h5>{$row["vcStatus"]}</h5></div></div></div></a>";
									}
					?>
									<div class="12u$">
										<ul class="actions">
											<li ><a href = <?php echo "\"print.php?jumperid={$jumperid}\""; ?> class = "button special" target="blank">Print</a></li>
										</ul>
									</div>
					<?php
								}
								else {
									$_SESSION["message"] = "Jumper-No Not Found.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=2");
								}
							}
						}
					?>
					<!--
					<?php 
						//if(isset($_GET["type"]) && $_GET["type"] === "3") {
					?>
							<div align = center >
								<h4>Enter Tag No. : </h4>
							</div>
							<form name = "TagForm" id = "TagForm" method = "post" action = "search.php?type=3">
								<div class = "row uniform">
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_unit" id="tag_unit" placeholder = "Unit" onblur="validateNonEmpty(this, document.getElementById('date_help1'))" />
											<span id="date_help1" class="help"></span>
									</div>
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_subsystem" id="tag_subsystem" placeholder = "Subsystem" onblur="validateNonEmpty(this, document.getElementById('date_help2'))" />
											<span id="date_help2" class="help"></span>
									</div>
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_system" id="tag_system" placeholder = "System" onblur="validateNonEmpty(this, document.getElementById('date_help3'))" />
											<span id="date_help3" class="help"></span>
									</div>
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_systemNo" id="tag_systemNo" placeholder = "System No." onblur="validateNonEmpty(this, document.getElementById('date_help4'))" />
											<span id="date_help4" class="help"></span>
									</div>
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_eqpt" id="tag_eqpt" placeholder = "Equipment" onblur="validateNonEmpty(this, document.getElementById('date_help5'))" />
											<span id="date_help5" class="help"></span>
									</div>
									<div class="2u 12u$(xsmall)">
										<input type="text" name="tag_eqptNo" id="tag_eqptNo" placeholder = "Equipmnt No." onblur="validateNonEmpty(this, document.getElementById('date_help6'))" />
											<span id="date_help6" class="help"></span>
									</div>
								</div>
								<br>
								<div align = center>
									<ul class="actions">
										<li ><input type="submit" name = "go_tag" value="Go!" class="special" /></li>
									</ul>
								</div>
							</form>
					<?php
						/*
							if(isset($_POST["go_tag"])&&!empty($_POST["tag_unit"])&&!empty($_POST["tag_subsystem"])&&!empty($_POST["tag_system"])&&!empty($_POST["tag_systemNo"])&&!empty($_POST["tag_eqpt"])&&!empty($_POST["tag_eqptNo"])) {
								//validations
								if(!preg_match("/^[0-9]{1}$/", $_POST["tag_unit"]) || !preg_match("/^[0-9]{1}$/", $_POST["tag_subsystem"]) || !preg_match("/^[a-zA-Z]{3}$/", $_POST["tag_system"]) || !preg_match("/^[0-9]{2}$/", $_POST["tag_systemNo"]) || !preg_match("/^[0-9a-zA-Z]{2}$/", $_POST["tag_eqpt"]) || !preg_match("/^[0-9]{3}$/", $_POST["tag_eqptNo"])) {
									$_SESSION["message"] = "Invalid Tag No.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=3");
								}
								if($result = get_jumpers_for_tag($_POST["tag_unit"], $_POST["tag_subsystem"], $_POST["tag_system"], $_POST["tag_systemNo"], $_POST["tag_eqpt"], $_POST["tag_eqptNo"])) {
									echo "<div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>Jumper No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>DR No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Proposed By</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Date</h5></div><div class=\"1u 12u$(xsmall)\"><h5>Stat</h5></div></div></div>";
									while($row = mysqli_fetch_assoc($result)) {
										$date_row = DATE($row["vcProposedbyDate"]);
										echo "<a href = \"layout1.php?jumperid={$row["intJumperID"]}\"><div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>{$row["vcJumperNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcDRNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcProposedby"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$date_row}</h5></div><div class = \"1u 12u$(xsmall)\"><h5>{$row["vcStatus"]}</h5></div></div></div></a>";
									}
								}
								else {
									$_SESSION["message"] = "Tag No Not Found.";
									$_SESSION["message_color"] = "red";
									redirect_to("sear	ch.php?type=3");
								}
							}
						}*/
					?>
					-->
					<?php 
						if(isset($_GET["type"]) && $_GET["type"] === "4") {
					?>
							<div align = center >
								<h4>Enter Date : </h4>
							</div>
							<form name = "DateForm" id = "DateForm" method = "post" action = "search.php?type=4">
								<div align = center>
									<div class="2u 12u$(xsmall)">
										<div class="ui-widget-content form_pad"><input type="text" name="enter_date" id="enter_date" placeholder = "YYYY-MM-DD"/></div>
									</div>
									<br>
									<ul class="actions">
										<li ><input type="submit" name = "go_date" value="Go!" class="special" /></li>
									</ul>
								</div>
							</form>
					<?php
							if(isset($_POST["go_date"])&&!empty($_POST["enter_date"])) {
								//validations
								if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST["enter_date"])) {
									$_SESSION["message"] = "Invalid Date Format Enter AS YYYY-MM-DD";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=4");
								}
								
								
								if($result = get_jumpers_for_date($_POST["enter_date"])) {
									echo "<div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>Jumper No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>DR No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Proposed By</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Date</h5></div><div class=\"1u 12u$(xsmall)\"><h5>Stat</h5></div></div></div>";
									echo "<div class=\"scrollable\">";
									while($row = mysqli_fetch_assoc($result)) {
										$date_row = DATE($row["vcProposedbyDate"]);
										echo "<a href = \"layout1.php?jumperid={$row["intJumperID"]}\"><div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>{$row["vcJumperNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcDRNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcProposedby"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$date_row}</h5></div><div class = \"1u 12u$(xsmall)\"><h5>{$row["vcStatus"]}</h5></div></div></div></a>";
									}
									echo "</div>";
								}
								else {
									$_SESSION["message"] = "Jumpers Not Found for Date.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=4");
								}
							}
						}
					?>
					<?php 
						if(isset($_GET["type"]) && $_GET["type"] === "5") {
					?>
							<div align = center >
								<h4>Enter Username : </h4>
							</div>
							<form name = "EmpForm" id = "EmpForm" method = "post" action = "search.php?type=5">
								<div align = center>
									<div class="4u 12u$(xsmall)">
										<input type="text" name="enter_emp" id="enter_emp" placeholder = "Enter Username" onblur="validateNonEmpty(this, document.getElementById('date_help'))" />
											<span id="date_help" class="help"></span>
									</div>
									<br>
									<ul class="actions">
										<li ><input type="submit" name = "go_emp" value="Go!" class="special" /></li>
									</ul>
								</div>
							</form>
					<?php
							if(isset($_POST["go_emp"])&&!empty($_POST["enter_emp"])) {
								//validations
								if(!preg_match("/^[0-9a-zA-Z_ ]*$/", $_POST["enter_emp"])) {
									//DR NO. not like 1-15-09-MM-002
									$_SESSION["message"] = "Invalid UserName (Only Alphabets, Digits, Underscores and Spaces)";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=5");
								}
								if($result = get_jumpers_for_employee($_POST["enter_emp"])) {
									echo "<div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>Jumper No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>DR No</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Proposed By</h5></div><div class=\"3u 12u$(xsmall)\"><h5>Date</h5></div><div class=\"1u 12u$(xsmall)\"><h5>Stat</h5></div></div></div>";
									echo "<div class=\"scrollable\">";
									while($row = mysqli_fetch_assoc($result)) {
										$date_row = DATE($row["vcProposedbyDate"]);
										echo "<a href = \"layout1.php?jumperid={$row["intJumperID"]}\"><div class = \"bordered\"><div class = \"row uniform\"><div class=\"2u 12u$(xsmall)\"><h5>{$row["vcJumperNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcDRNo"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$row["vcProposedby"]}</h5></div><div class=\"3u 12u$(xsmall)\"><h5>{$date_row}</h5></div><div class = \"1u 12u$(xsmall)\"><h5>{$row["vcStatus"]}</h5></div></div></div></a>";
									}
									echo "</div>";
								}
								else {
									$_SESSION["message"] = "Jumpers for Employee Not Found.";
									$_SESSION["message_color"] = "red";
									redirect_to("search.php?type=5");
								}
							}
						}
					?>
				</section>
			</div>
		</div>
	</section>
</article>
<?php include("../includes/layouts/footer_inside.php");?>
