<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$semesterSeq =  $_GET['semesterSeq'];
	
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

	$stmt = $conn->prepare("DELETE FROM semester WHERE semester_seq = ? and member_seq = ?");
	$stmt->bind_param("ss", $semesterSeq,$memberSeq);
	$stmt->execute();
	$stmt->close();



	//select last record and change to be selectedterm
	$stmt = $conn->prepare("SELECT * FROM semester where member_seq = ? 
		ORDER BY semester_seq DESC LIMIT 1");
	$stmt->bind_param("s",$memberSeq);
	$stmt->execute();
	$stmt->bind_result($id,$name,$year,$startDate,$endDate,$addChangeStartDate,$addChangeEndDate,
                      $withdrawStartDate,$withdrawEndDate,$memberSeq,$selected);
    $stmt->fetch();

    $newId = $id; //semester_seq of last record

    //semesterDetail of last record
    $idSemesterSelected = $id;
    $nameSemesterSelected = $name;
    $yearSemesterSelected = $year;
    $startDateSelected = date("d M Y", strtotime($startDate));
    $endDateSelected = date("d M Y", strtotime($endDate));;
    $addChangeStartDateSelected = date("d M Y", strtotime($addChangeStartDate));
    $addChangeEndDateSelected = date("d M Y", strtotime($addChangeEndDate));
    $withdrawStartDateSelected = date("d M Y", strtotime($withdrawStartDate));
    $withdrawEndDateSelected = date("d M Y", strtotime($withdrawEndDate));

    $semesterDetail = array(
    			'id'=> $idSemesterSelected,
    			'name'=> $nameSemesterSelected,
    			'year'=> $yearSemesterSelected,
    			'startDate'=> $startDateSelected,
    			'endDate'=> $endDateSelected,
    			'addChangeStartDate'=> $addChangeStartDateSelected,
    			'addChangeEndDate'=> $addChangeEndDateSelected,
    			'withdrawStartDate'=> $withdrawStartDateSelected,
    			'withdrawEndDate'=> $withdrawEndDateSelected
    		);

  
    print json_encode($semesterDetail);


    $stmt->close();

	$stmt = $conn->prepare("UPDATE semester SET semester_selected = '1' WHERE semester_seq = ?");
	$stmt->bind_param("s",$newId);
	$stmt->execute();



	$conn->close();
?> 