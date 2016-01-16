<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$term =  $_POST['term'];
	$val = '1';
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

	//update set old value to be unselected term

	$stmt = $conn->prepare("UPDATE semester SET semester_selected = '0' WHERE member_seq = ? and semester_selected = '1'");
	$stmt->bind_param("s", $memberSeq);
	$stmt->execute();


	//insert new semester and changed to be selected term

	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO semester (semester_name,semester_year,semester_school_start
	,semester_school_break,semester_add_and_change_start
	,semester_add_and_change_end,semester_drop_start,
	semester_drop_end,member_seq,semester_selected) VALUES (?, ?, ?, ?, ?, ?, ?, ? ,? ,?)");
	$stmt->bind_param("ssssssssss", $term['name'], $term['year'],$term['startDate'],$term['endDate'],$term['addChangeStartDate'],$term['addChangeEndDate'],$term['withdrawStartDate'],$term['withdrawEndDate'],$memberSeq,$val);


	$stmt->execute();
	$result = $stmt->insert_id;

	echo $result;

	


	$stmt->close();
	$conn->close();
?> 