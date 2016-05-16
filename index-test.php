

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
	$user = $_SESSION["username"]; 
	// table.php
	
	//getting our config
	require_once ("../../config.php");
	
	//create connection
	$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
	
	/*
		IF THERE IS ?DELETE=ROW_ID in the url
	*/

		if(isset($_GET["delete"])) {
			
			echo "Deleting row with id:".$_GET["delete"];
			
			// NOW () = current date-time
			$stmt = $mysql->prepare("UPDATE debattle_request SET deleted=NOW() WHERE id = ?");
			
			// replace the ?. The i here is an integer for the id number
			
			$stmt->bind_param ("i", $_GET["delete"]);
		
			if ($stmt->execute()){
				echo " Deleted successfully";
			}else{
				echo $stmt->error;
			}
			
			//Closes the statement, so others can use connection
			$stmt->close();
		}
	

	//SQL sentence // to show all results, remove ORDER 
	$stmt = $mysql->prepare("SELECT id, username, challengee, motion, position, visibility, start_date, end_date, characters, favcolor, reply, created FROM debattle_request WHERE visibility = 'Open' AND DELETED IS NULL ORDER BY created LIMIT 30 ");
	
	// on the above WHERE, WHERE deleted IS NULL show only those that are not deleted. WHERE should be before the ORDER
	
	//if error in sentence
	echo $mysql->error;
	
	//variable for data for each row we will get
	$stmt->bind_result($id, $username, $challengee, $motion, $position, $visibility, $start_date, $end_date, $characters, $favcolor, $reply, $created);

	//query
	$stmt->execute ();
	
	//Create a table
	
	$table_html = "";
	
	//add somthing to string .=
	$table_html .= "<table class='table table-bordered table-hover table-striped'>";
	$table_html .= "<tr>"; //table row
		$table_html .= "<th>From</th>"; //table header
		$table_html .= "<th>Challengee</th>"; //table header
		$table_html .= "<th>Motion</th>"; //table header
		$table_html .= "<th>Position</th>"; //table header
		$table_html .= "<th>Visibility</th>"; //table header
		$table_html .= "<th>Start Date</th>"; //table header
		$table_html .= "<th>End Date</th>"; //table header
		$table_html .= "<th>Favourite Colour</th>"; //table header
		$table_html .= "<th>Characters</th>"; //table header
		$table_html .= "<th>Reply</th>"; //table header
		$table_html .= "<th>Created</th>"; //table header

	$table_html .= "</tr>"; //table row closing
	
	// GET RESULTS
	// we have multiple rows, the while loop
	while ($stmt->fetch()) {
		
		// Do SOMETHING FOR EACH ROW //the dots are actual spaces
		//echo $id." ".$challengee. "<br>";
		$table_html .= "<tr>"; //start a new row
		$table_html .= "<td>" .$username. "</td>"; //add coloumns
		$table_html .= "<td>" .$challengee. "</td>"; 
		$table_html .= "<td>" .$motion. "</td>"; 
		$table_html .= "<td>" .$position. "</td>"; 
		$table_html .= "<td>" .$visibility. "</td>"; 
		$table_html .= "<td>" .$start_date. "</td>"; 
		$table_html .= "<td>" .$end_date. "</td>";
		$table_html .= "<td><div style='height:10px;width:10px;background-color:".$favcolor."'></div>" .$favcolor. "</td>";  
		$table_html .= "<td>" .$characters. "</td>"; 
		$table_html .= "<td>" .$reply. "</td>";
		$table_html .= "<td>" .$created. "</td>";
				
	$table_html .= "</tr>"; //end row
		
	}
	$table_html .= "</table>";
	
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
      <a class="navbar-brand active" href="index.php">Debattle</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li> <a href="Debattle_b.php">Request</a></li>
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
	
		<h1> Open Debattles </h1>
		<?php echo $table_html; ?>






  </body>
</html>