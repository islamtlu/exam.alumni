
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
		header("Location: show.php");
		exit (); //don't execute further
		
	}else{
		
		$notice = "You want to edit Alumni Entry no.:".$_GET["edit"];
		
		//ask for latest data for single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
		
		//may be user wantes to update data after clicking the button 
		
		if(isset($_GET["name"]) && isset ($_GET["university"])){
			
			echo "User modified data, trying to save";
			
			// should be validation?
			
			$stmt = $mysql->prepare("UPDATE alumni_database SET name=?, university=?, email=? WHERE id=?");
			
			echo $mysql->error;
			
			$stmt->bind_param("sssi", $_GET["name"], $_GET["university"], $_GET["email"], $_GET["edit"]);
			
			if($stmt->execute()){
				
				
				echo "Saved successfully";
				
				//option one
				
				//header ("Location: table.php");
				//exit ();
				
				//option two - update variables
				
				$name = $_GET["name"];
				$university = $_GET["university"];
				$email = $_GET["email"];
				$id = $_GET["edit"];
				
				header("Location: show.php");
				
			}else{
				
				echo $stmt->error;
			}
			
		}else{
			
			//user did not click any buttons yet,
			//give user latest data from database
			
		$stmt = $mysql->prepare("SELECT id, name, university, email FROM alumni_database WHERE id=?");
		
		echo $mysql->error;
		
		//replace the ? mark   id = integer
		$stmt->bind_param("i", $_GET["edit"]);
		
		//bind result data
		$stmt->bind_result($id, $name, $university, $email);
		
		$stmt->execute();
		
		//we have only 1 row of data
		
		if($stmt->fetch()){
			$data="";
			//we had data
			$data= $name." ".$university." ".$email;
			
		}else{
			
			//something went wrong
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
      <a class="navbar-brand" href="#">Alumni</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="add.php">Add</a></li>
		<li class="active"><a href="show.php"> Show</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
        <li><a >Welcome <?=$_SESSION["first_name"];?></a></li>
		<li> <a href="?logout=1"> Log Out</a></li>
          </ul>
    
	
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<div class="container">
	
		<h1> Edit your Alumni Entry </h1>
		<h3> Connecting with Classmates Everywhere </h3>
		<br>
		<?=$notice;?> 
		<form>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="challengee">Enter Your Name</label>
					<input name="edit" type="hidden" value="<?=$_GET["edit"];?>">
					<input name="name" id="name" type="text" value="<?=$name;?>" class="form-control">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="university">Enter your University</label>
					<input name="university" id="university" type="text" value="<?=$university;?>" class="form-control">
					</div>
				</div>		
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="email">Enter your E-mail address</label>
					<input name="email" id="email" type="email" value="<?=$email;?>" class="form-control">
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