
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
	$everything_was_okay = true;
	$notice="";
	$username = $_SESSION["username"]; 
	//*******************
	//To form validation
	//*******************
	if(isset($_GET["name"])){ //if there is ?name= in the URL
		if(empty($_GET["name"])){ //if it is empty
			$everything_was_okay = false; //empty
			echo "Please enter your name! <br>"; // yes it is empty
		}else{
			echo "Name: ".$_GET["name"]."<br>"; //no it is not empty
		}
	}else{
		$everything_was_okay = false; // do not exist
	}
	//check if there is variable in the URL
	if(isset($_GET["university"])){
		
		//only if there is university in the URL
		//echo "there is university";
		
		//if its empty
		if(empty($_GET["university"])){
			//it is empty
			$everything_was_okay = false;
			echo "Please enter the name of your University!";
		}else{
			//its not empty
			echo "University: ".$_GET["university"]."<br>";
		}
		
	}else{
		//echo "there is no such thing as university";
		$everything_was_okay = false;
	}
	
		if(isset($_GET["email"])){
		
		//only if there is email in the URL
		//echo "there is email";
		
		//if its empty
		if(empty($_GET["email"])){
			//it is empty
			$everything_was_okay = false;
			echo "Please enter your E-Mail address!";
		}else{
			//its not empty
			echo "Email: ".$_GET["email"]."<br>";
		}
		
	}else{
		//echo "there is no such thing as university";
		$everything_was_okay = false;
	}


	
	//Getting the message from address
	// if there is ?name= .. then $_GET["name"]
	//$my_motion = $_GET["motion"];
	//$to = $_GET["to"];
	
	
	//echo "My motion is ".$my_motion." and is to ".$to;
	
		/***********************
	**** SAVE TO DB ********
	***********************/
	// ? was everything okay
	if($everything_was_okay == true){
		
		//echo "Sending Debattle Request ...";
		
		//connection with username and password
		//access username from config
		//echo $db_username;
		
		//1 servername: localhost or greeny server
		//2 username
		//3 password
		//4 database
		

		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
		$stmt = $mysql->prepare ("INSERT INTO alumni_database (username, name, university, email) VALUES (?,?,?,?)");
		
		//echo error
		echo $mysql->error;
		
		//we are repalcing question marks with values
		//s - string, date, smth that is based on characters and numbers
		// i - integer, number
		// d - decimanl, float
		
		//for each question mark its type with one letter
		$stmt->bind_param ("ssss", $_SESSION["username"], $_GET["name"], $_GET["university"], $_GET["email"]);
		
		//save
		if ($stmt->execute ()){
			$notice = "Entry sent";
		}else{
			echo $stmt->error;
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
      <a class="navbar-brand" href="#">Alumni</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="add.php">Add</a></li>
		<li><a href="show.php"> Show</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
        <li><a >Welcome <?=$_SESSION["first_name"];?></a></li>
		<li> <a href="?logout=1"> Log Out</a></li>
          </ul>
    
	
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<div class="container">
	
		<h1> Add an Alumnus/Alumna </h1>
		<h3> Connecting with Classmates Everywhere </h3>
		<?=$notice;?>
		<br>


		<form>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="name">Enter Your Name</label>
					<input name="name" id="name" placeholder="your full name" type="text" class="form-control">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="university">Enter your University</label>
					<input name="university" id="university" type="text" class="form-control">
					</div>
				</div>		
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="email">Enter your E-mail address</label>
					<input name="email" id="email" type="email" class="form-control">
					</div>
				</div>		
			</div>			

			<div class="row">
				<div class="col-md-3 col-sm-6">
					<input class="btn btn-success hidden-xs" type="submit" value="Add">
					<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Add Now">
				</div>
			</div>
<br>
			<div class="row">
		
			</div>
			
		</form>




  </body>
</html>