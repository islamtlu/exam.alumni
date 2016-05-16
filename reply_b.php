
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
		header("Location: received_b.php");
		exit (); //don't execute further
		
	}else{
		
		$notice = "You want to reply to a Debattle no.:".$_GET["edit"];
		
		//ask for latest data for single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
		
		//may be user wantes to update data after clicking the button 
		
		if(isset($_GET["username"]) && isset ($_GET["motion"])){
			
			echo "User modified data, trying to save";
			
			// should be validation?
			
			$stmt = $mysql->prepare("UPDATE debattle_request SET username=?, motion=?, position=?, visibility=?, start_date=?, end_date=?, favcolor=?, characters=?, reply=? WHERE id=?");
			
			echo $mysql->error;
			
			$stmt->bind_param("sssssssisi", $_GET["username"], $_GET["motion"], $_GET["position"], $_GET["visibility"], $_GET["start_date"], $_GET["end_date"], $_GET["favcolor"], $_GET["characters"], $_GET["reply"], $_GET["edit"]);
			
			if($stmt->execute()){
				
				
				echo "Saved successfully";
				
				//option one
				
				//header ("Location: table.php");
				//exit ();
				
				//option two - update variables
				
				$username = $_GET["username"];
				$motion = $_GET["motion"];
				$position = $_GET["position"];
				$visibility = $_GET["visibility"];
				$start_date = $_GET["start_date"];
				$end_date = $_GET["end_date"];
				$favcolor = $_GET["favcolor"];
				$characters = $_GET["characters"];
				$reply = $_GET["reply"];
				$id = $_GET["edit"];
				
				header("Location: received_b.php");
				
			}else{
				
				echo $stmt->error;
			}
			
		}else{
			
			//user did not click any buttons yet,
			//give user latest data from database
			
		$stmt = $mysql->prepare("SELECT id, username, motion, position, visibility, start_date, end_date, favcolor, characters, reply FROM debattle_request WHERE id=?");
		
		echo $mysql->error;
		
		//replace the ? mark   id = integer
		$stmt->bind_param("i", $_GET["edit"]);
		
		//bind result data
		$stmt->bind_result($id, $username, $motion, $position, $visibility, $start_date, $end_date, $favcolor, $characters, $reply);
		
		$stmt->execute();
		
		//we have only 1 row of data
		
		if($stmt->fetch()){
			$data="";
			//we had data
			$data= $username." ".$motion." ".$position." ".$visibility." ".$start_date." ".$end_date." ".$favcolor." ".$characters." ".$reply;
			
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
      <a class="navbar-brand" href="index.php">Debattle</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="Debattle_b.php">Request</a></li>
		<li><a href="table_b.php"> Sent</a></li>
		<li class="active"><a href="received_b.php"> Received</a></li>
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
	
		<h1> Reply To A Debattle </h1>
		<h3> Everything is Challengeable </h3>
		<br>
		<?=$notice;?> 
		<form>

						<div class="row">
			<div class="col-md-3">
					<div class="form-group">
					<label for="characters">Enter your response</label>
					<textarea class="form-control" name="reply" id="reply" maxlength="<?= $characters;?>" value="" class="form-control"><?= $reply;?></textarea>
					</div>
				</div>			
			</div>

			<div class="row">
				<div class="col-md-3 col-sm-6">
					<input class="btn btn-success hidden-xs" type="submit" value="Send your Challenge Reply">
					<input class="btn btn-success btn-block visible-xs-block" type="submit" value="Send your Challenge Reply Now">
				</div>
			</div>
<br>

			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="challengee">User who challenged you</label>
					<input name="edit" type="hidden" value="<?=$_GET["edit"];?>">
					<input name="username" name="username" placeholder="@" type="text" value="<?=$username;?>" class="form-control" readonly>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
					<label for="motion">Motion</label>
					<input name="motion" id="motion" type="text" value="<?=$motion;?>" class="form-control" readonly>
					</div>
				</div>		
			</div>
			
			<div class="row">
				<div class="col-md-3">
				<label for="position">Position</label>
				
					<?php if($position == "Pro"): ?>
					
						<div class="radio">
						<label><input type="radio" id="position" value="Pro" name="position" checked readonly> Pro </label>
						</div>
						
						<div class="radio">
						<label><input type="radio" id="position" value="Against" name="position" readonly> Against  </label>
						</div>
						
					<?php else: ?>
					
						<div class="radio">
						<label><input type="radio" id="position" value="Pro" name="position"readonly> Pro </label>
						</div>
						
						<div class="radio">
						<label><input type="radio" id="position" value="Against" name="position" checked readonly> Against  </label>
						</div>

					<?php endif; ?>
				
				</div>			
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
				<label for="visibility">Visibility</label>
				
					<?php if($visibility == "Open"): ?>
					
						<div class="radio">
						<label><input type="radio" id="visibility" value="Open" name="visibility" checked readonly> Open </label>
						</div>
						
						<div class="radio">
						<label><input type="radio" id="visibility" value="Closed" name="visibility" readonly> Closed  </label>
						</div>
						
					<?php else: ?>
					
						<div class="radio">
						<label><input type="radio" id="visibility" value="Open" name="visibility" readonly> Open </label>
						</div>
						
						<div class="radio">
						<label><input type="radio" id="visibility" value="Closed" name="visibility" checked readonly> Closed  </label>
						</div>

					<?php endif; ?>
				</div>			
			</div>
			<br>
			<div class="row">
				<div class="col-md-3">
				<label for="bday">Start Date</label>
				
					<div class="date">
					<input type="date" class="form-control" name="start_date" id="start_date" value="<?= $start_date;?>" readonly> 
					</div>
				</div>	
			</div>
			<br>
			<div class="row">
			<div class="col-md-3">
			<label for="bday2">End Date</label>
				
					<div class="date">
					<input type="date" class="form-control" name="end_date" id="end_date" value="<?= $end_date;?>" readonly> 
					</div>
			</div>			
			</div>
			<br>
			<div class="row">
			<div class="col-md-3">
			<label for="colour">Choose your favourite colour</label>
				
					<div class="color">
					<input type="color" class="form-control" name="favcolor" id="favcolor" value="<?= $favcolor;?>" readonly> 
					</div>	
				</div>		
			</div>
			<br>
				
			<div class="row">
			<div class="col-md-3">
					<div class="form-group">
					<label for="characters">Set the number of characters</label>
					<input type="number" class="form-control" name="characters" value="<?= $characters;?>" min="1" max="300" class="form-control" readonly>
					</div>
				</div>			
			</div>

			
			<div class="row">
		
			</div>
			
		</form>




  </body>
</html>