<?php

	require_once ("../../config.php");
	
	//start server session to store data
	//in every file you want to access session
	//you should require functions file
	
	//session is stored on the server, cookies is on your computer
	session_start();
	
	function login($user, $pass){
		
		//hash the password
		$pass = hash ("sha512", $pass);	

		//GLOBALS - access outside variable in function, this is to access the configuration file
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");	

		$stmt = $mysql->prepare("SELECT id, first_name, last_name FROM debattle_users WHERE username=? and password=?");
		
		echo $mysql->error;
		
		$stmt->bind_param("ss", $user, $pass);
		
		$stmt->bind_result($id,$first_name, $last_name);
		
		$stmt->execute();
		
		//Get the data
		if ($stmt->fetch()){
			echo "User with id ".$id." logged in!";
			
			//create sessions variables
			//redirect user
			$_SESSION["user_id"] = $id;
			$_SESSION["username"] = $user;
			$_SESSION["first_name"] = $first_name;
			$_SESSION["last_name"] = $last_name;
			
			//redirection part
			header ("Location: add.php");
			
		}else{
			//username was wrong, password was wrong, or both
			echo $stmt->error;
			echo "Worng login credentials.";
		}
		
	}
	
	function signup($first_name, $last_name, $user, $pass){
		
		//hash the password
		$pass = hash ("sha512", $pass);
		
		//GLOBALS - access outside variable in function, this is to access the configuration file
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");
		
		$stmt = $mysql->prepare("INSERT INTO debattle_users (first_name, last_name, username, password) VALUES (?,?,?,?)");
		
		echo $mysql->error;
		
		$stmt->bind_param("ssss", $first_name, $last_name, $user, $pass);
		
		if($stmt->execute()){
			return "User has been created successfully!";

		}else{
			//this is to show if there is a SQL error
			return $stmt->error;
		}
	}
	

	function saveInterest($interest){
	$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");
		
	$stmt = $mysql->prepare("INSERT INTO debattle_interest (interest) VALUES (?)");
	
	echo $mysql->error;
	
	$stmt->bind_param("s", $interest);
	
			if($stmt->execute()){
			echo "Topic has been created successfully!";
		}else{
			//this is to show if there is a SQL error
			echo $stmt->error;
		}
	}
	
	function createInterestDropdown (){
		//query all interests
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");
		
		$stmt = $mysql->prepare("SELECT id, interest FROM debattle_interest ORDER BY interest ASC");
		
		echo $mysql->error;
	
		$stmt->bind_result($id, $interest);
		
		$stmt->execute ();
		
		//dropdown menu
		$html = "<select name='debattle_user_interest'>";
		
		//for each interest
		while($stmt->fetch()){
			$html .= "<option value='".$id."'>".$interest."</option>";
		}
		
		$html .= "</select>";
		echo$html;
	}

	
	function saveUserInterest($interest_id){
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");	
		
		//if user already has to the interest
		$stmt = $mysql->prepare("SELECT id FROM debattle_user_interest WHERE user_id = ? and interests_id = ?");
		echo $mysql->error;
		$stmt->bind_param("ii", $_SESSION["user_id"], $interest_id);
		$stmt->execute();
		
		if($stmt->fetch()){
			//it existed
			echo "You already have this topic";
			return; //stop it there
		}
		$stmt->close();
		
		
		
		$stmt = $mysql->prepare("INSERT INTO debattle_user_interest (user_id, interests_id) VALUES (?,?)");
		
		echo $mysql->error;
		
		//$_SESSION["user_id"] logged in user ID
		
		$stmt->bind_param("ii", $_SESSION["user_id"], $interest_id);
		
		if($stmt->execute()){
			echo "Save successfully";	
		}else{
			echo $stmt->error;
		}
		
	}
	function createUserInterestList (){
		$mysql = new mysqli("localhost", $GLOBALS["db_username"], $GLOBALS["db_password"], "webpr2016_islam");

		$stmt = $mysql->prepare("SELECT debattle_interest.interest FROM debattle_user_interest INNER JOIN debattle_interest ON debattle_user_interest.interests_id = debattle_interest.id WHERE debattle_user_interest.user_id = ?");
		
		$stmt->bind_param("i", $_SESSION["user_id"]);
		
		$stmt->bind_result($interest);
		
		$stmt->execute();
		
		$html = "<ul>";
		
		// for each interest
		while($stmt->fetch()){
			$html .= "<li>".$interest."</li>";
		}
		
		$html .= "</ul>";
		
		
		echo $html;
		
	
		
	}



	
	/*$name = "Islam";

	hello($name, "thursday", 7);
	hello("Toomas", "thursday", 1);

	function hello ($received_name, $day_of_the_week, $day){
		echo "Hello " .$received_name."!";
		echo "<br>";
		echo "Today is ".$day_of_the_week." ".$day;
		echo "<br>";
	}*/


?>