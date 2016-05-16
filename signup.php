

<?php require_once ("header.php"); ?>
<?php
	require_once("functions.php");
	
	//Restriction - Not logged in
	if(isset($_SESSION["user_id"])){
		//redirect user to restricted page
		header("Location: login.php");
	}
	
	$notice="";

	//login=something is in the URL
	if(isset($_POST["signup"])){
		
		//signup
		
		//echo "signing up ...";
		
		//Check the fields are not empty
		if (!empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["username"]) && !empty ($_POST["password"])){
			
			//save to DB
			
			$notice = signup($_POST["first_name"], $_POST["last_name"], $_POST["username"], $_POST["password"]);
		}else{
			
			$notice= "All fields are required!";
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
        <li><a href="login.php">Login</a></li>
		<li class="active"> <a href="signup.php">Sign Up</a></li>
          </ul>
    
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<div class="container">
	
		<h1> Join Debattle </h1>
		<h3> Enter your details </h3>
		<br>
		<?=$notice;?>
		<form method="POST">
		
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="first_name">First Name</label>
					<input name="first_name" id="first_name" placeholder="Enter your first name" type="text" class="form-control">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="last_name">Last Name</label>
					<input name="last_name" id="last_name" placeholder="Enter your last name" type="text" class="form-control">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="username">Username</label>
					<input name="username" id="username" placeholder="@" type="text" class="form-control">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="password">Password</label>
					<input name="password" id="password" placeholder="Enter your preferred password" type="password" class="form-control">
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<input class="btn btn-success hidden-xs" type="submit" name="signup" value="Register">
					<input class="btn btn-success btn-block visible-xs-block" type="submit" name="signup" value="Register Now">
				</div>
			</div>
			<br>
