

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
			$stmt = $mysql->prepare("UPDATE alumni_database SET deleted=NOW() WHERE id = ?");
			
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
	$stmt = $mysql->prepare("SELECT id, name, university, email, created FROM alumni_database WHERE DELETED IS NULL ORDER BY created LIMIT 30 ");
	
	// on the above WHERE, WHERE deleted IS NULL show only those that are not deleted. WHERE should be before the ORDER
	
	//if error in sentence
	echo $mysql->error;
	
	//variable for data for each row we will get
	$stmt->bind_result($id, $name, $university, $email, $created);

	//query
	$stmt->execute ();
	
	//Create a table
	
	$table_html = "";
	
	//add somthing to string .=
	$table_html .= "<table class='table table-bordered table-hover table-striped'>";
	$table_html .= "<tr>"; //table row
		$table_html .= "<th>ID</th>"; //table header
		$table_html .= "<th>Name</th>"; //table header
		$table_html .= "<th>University</th>"; //table header
		$table_html .= "<th>E-Mail</th>"; //table header
		$table_html .= "<th>Created</th>"; //table header
		$table_html .= "<th>Delete?</th>"; //table header
		$table_html .= "<th>Edit</th>"; //table header
	$table_html .= "</tr>"; //table row closing
	
	// GET RESULTS
	// we have multiple rows, the while loop
	while ($stmt->fetch()) {
		
		// Do SOMETHING FOR EACH ROW //the dots are actual spaces
		//echo $id." ".$challengee. "<br>";
		$table_html .= "<tr>"; //start a new row
		$table_html .= "<td>" .$id. "</td>"; //add coloumns
		$table_html .= "<td>" .$name. "</td>"; 
		$table_html .= "<td>" .$university. "</td>"; 
		$table_html .= "<td>" .$email. "</td>"; 
		$table_html .= "<td>" .$created. "</td>";
    	$table_html .= "<td><a class= 'btn btn-danger' href='?delete=" .$id."'>Delete</a></td>";
		$table_html .= "<td><a class= 'btn btn-success'  href='edit_b.php?edit=".$id."'>Edit</a></td>";	
				
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
      <a class="navbar-brand" href="#">Alumni</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li> <a href="add.php">Add</a></li>
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
	
		<h1> Current Alumni </h1>
		<?php echo $table_html; ?>






  </body>
</html>