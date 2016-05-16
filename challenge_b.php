
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
	

?>


<?php
	// require another php file
	// ../../ => 2 folders back - navigating to where the config file it
	require_once ("../../config.php");
	
	//the variable doesn't exist in the URL
	if(!isset($_GET["edit"])){
			$notice="";
		//redirect user
		echo "redirect";
		header("Location: users.php");
		exit (); //don't execute further
		
	}else{
		
		$notice = "You want to challenge:".$_GET["edit"];
		
		//ask for latest data for single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
		
		//may be user wantes to update data after clicking the button 
		
		if(isset($_GET["challengee"]) && isset ($_GET["motion"])){
			
			echo "User modified data, trying to save";
			
			// should be validation?
			
			$stmt = $mysql->prepare ("INSERT INTO debattle_request (username, challengee, motion, position, visibility, start_date, end_date, favcolor, characters) VALUES (?,?,?,?,?,?,?,?,?)");
			
			echo $mysql->error;
			
			$stmt->bind_param("ssssssssi", $_SESSION["username"], $_GET["edit"], $_GET["motion"], $_GET["position"], $_GET["visibility"], $_GET["start_date"], $_GET["end_date"], $_GET["favcolor"], $_GET["characters"]);
			
			if($stmt->execute()){
				
				
				echo "Saved successfully";
				
				//option one
				
				//header ("Location: table.php");
				//exit ();
				
				//option two - update variables
				
				
				header("Location: users.php");
				
			}else{
				
				echo $stmt->error;
			}
			
		
		}
		
	}
	
?>

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
        <li class="active"><a href="Debattle_b.php">Request</a></li>
		<li><a href="table_b.php"> Sent</a></li>
		<li><a href="received_b.php"> Received</a></li>
		<li> <a href="users.php"> Users</a></li>
		<li> <a href="topic.php"> Topics</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
        <li><a >Welcome <?=$_SESSION["first_name"];?></a></li>
		<li> <a href="?logout=1"> Log Out</a></li>
          </ul>
    
	
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<div class="container">
	
		<h1> Start A Debattle </h1>
		<h3> Everything is Challengeable </h3>
		<br>
		<?=$notice;?> 
		<form>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="challengee">User to Challenge</label>
					<input name="edit" type="hidden" value="<?=$_GET["edit"];?>">
					<input name="challengee" id="challengee" placeholder="@" type="text" value="<?=$_GET["edit"];?>" class="form-control" readonly>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="motion">Motion</label>
					<input name="motion" id="motion" type="text" value="" class="form-control">
					</div>
				</div>		
			</div>
			
			<div class="row">
				<div class="col-md-3">
				<label for="position">Position</label>
				
					<div class="radio">
					<label><input type="radio" id="position" value="Pro" name="position"> Pro </label>
					</div>
					
					<div class="radio">
					<label><input type="radio" id="position" value="Against" name="position"> Against  </label>
					</div>
				</div>			
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
				<label for="visibility">Visibility</label>
				
					<div class="radio">
					<label><input type="radio" id="visibility" value="Open" name="visibility"> Open </label>
					</div>
					
					<div class="radio">
					<label><input type="radio" id="visibility" value="Closed" name="visibility"> Closed </label>
					</div>
				</div>			
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
				<label for="bday">Start Date</label>
				
					<div class="date">
					<input type="date" class="form-control" name="start_date" id="start_date" value=""> 
					</div>
				</div>	
			</div>
			<br>
			<div class="row">
			<div class="col-md-3">
			<label for="bday2">End Date</label>
				
					<div class="date">
					<input type="date" class="form-control" name="end_date" id="end_date" value=""> 
					</div>
			</div>			
			</div>
			<br>
			<div class="row">
			<div class="col-md-3">
			<label for="colour">Choose your favourite colour</label>
				
					<div class="color">
					<input type="color" class="form-control" name="favcolor" id="favcolor" value=""> 
					</div>	
				</div>		
			</div>
			<br>
				
			<div class="row">
			<div class="col-md-3">
					<div class="form-group">
					<label for="characters">Set the number of characters</label>
					<input type="number" class="form-control" name="characters" value="" min="1" max="300" class="form-control">
					</div>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-3 col-sm-6">
					<input class="btn btn-success hidden-xs" type="submit" value="Save your Challenge">
					<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Save your Challenge Now">
				</div>
			</div>
<br>
			<div class="row">
		
			</div>
			
		</form>




  </body>
</html>