<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	// echo $term['name'];
	// print_r($term); //for testing structure of TERM DATA

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

	// prepare and bind
	$stmt = $conn->prepare("SELECT semester_seq ,semester_name,semester_year,semester_selected FROM semester where member_seq =?");
	$stmt->bind_param("s",$memberSeq);


	$stmt->execute();
	$stmt->bind_result($id,$name,$year,$selected);

	$semesterList = array();


    while($stmt->fetch()){

    	//printf("%s,%s,%s,%s\n",$id,$name,$year,$selected);
    	$row_array['id'] = $id;
    	$row_array['name'] = $name;
    	$row_array['year'] = $year;
    	$row_array['selected'] = $selected;

    	array_push($semesterList,$row_array);
    }

    
    echo json_encode($semesterList);


	$stmt->close();
	$conn->close();

?>