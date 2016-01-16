<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$term =  $_POST['term'];
	
	//echo $term['name'];
	print_r($term); //for testing structure of TERM DATA

	$servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);


	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}


	$stmt = $conn->prepare("UPDATE semester SET semester_name = ?,semester_school_start = ? WHERE semester_seq = ?");
	$stmt->bind_param("sss",$term['name'],$term['startDate'],$term['semesterSeq']);
	$stmt->execute();



	$conn->close();
?> 