<?php require_once ("header.php"); ?>


<?php
	
	//we need functions file for dealing with session
	require_once("functions.php");
	
		//Restriction -  logged in
	if(!isset($_SESSION["user_id"])){
		//redirect not logged in user to login page
		header("Location: login.php");
	}
	
	//?logout is in the URL
	if(isset($_GET["logout"])){
		
		//delete the session
		session_destroy();
		
		header("Location: login.php");
	}
	
	//someone clicked the button "add"
	if(isset($_GET["add_new_interest"])){
		
		if(!empty($_GET["new_interest"])){
		saveInterest($_GET["new_interest"]);
				header("Location: topic.php");
	}else{
		echo "You left the Interest field empty";
	}
	
	}
	
//someone clicked the button select_interest
if(isset($_GET["select_interest"])){
	if(!empty($_GET["debattle_user_interest"])){
		
	saveUserInterest($_GET["debattle_user_interest"]);
					header("Location: topic.php");
}else{
	echo "error";
}
}

?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Debattle</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="Debattle_b.php">Request</a></li>
		<li><a href="table_b.php"> Sent</a></li>
		<li><a href="received_b.php"> Received</a></li>
		<li> <a href="users.php"> Users</a></li>
		<li class="active"> <a href="topic.php"> Topics</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
        <li><a >Welcome <?=$_SESSION["first_name"];?></a></li>
		<li> <a href="?logout=1"> Log Out</a></li>
          </ul>

              </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<form>
	<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="challengee">Add Debattle Topic</label> <br>
					<input type="text" name="new_interest" class="form-control"> <br>
					<input class="btn btn-success hidden-xs" type="submit" name="add_new_interest" class="form-control" value="Submit">
										</div>
				</div>
			</div>
	
</form>

<form>
<div class="dropdown">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
				<label for="interest">Add your favourite Debattle Topic</label> <br>
				<?php 	createInterestDropdown(); ?> <br> <br>
  				<input type="submit" class="btn btn-success hidden-xs" name="select_interest" value="Select" class="form-control">
				</div>
			</div>
		</div>
</div>



</form>

<h4>Favourite Topics</h4>

<?php 	createUserInterestList(); ?>

