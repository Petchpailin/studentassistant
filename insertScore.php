<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$subject =  $_GET['subject'];
	$val = json_decode($subject,true);

	$servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";


	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);



	//Check connection
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	else{
			
	}
	mysqli_close($conn);
?>
