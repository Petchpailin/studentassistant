<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$semesterSeq = $_GET['semesterSeq'];
	//echo $semesterSeq;
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

	//change to be unselected semester
	$stmt = $conn->prepare("UPDATE semester SET semester_selected = '0' WHERE member_seq = ? and semester_selected = '1'");
	$stmt->bind_param("s", $memberSeq);
	$stmt->execute();

	//changed to be selected semester
	$stmt = $conn->prepare("UPDATE semester SET semester_selected = '1' WHERE member_seq = ? and semester_seq = ?");
	$stmt->bind_param("ss", $memberSeq,$semesterSeq);
	$stmt->execute();


	// get semesterDetail
	$stmt = $conn->prepare("SELECT * FROM semester where member_seq = ? and semester_seq = ?");
	$stmt->bind_param("ss",$memberSeq,$semesterSeq);


	$stmt->execute();


	$stmt->bind_result($id,$name,$year,$startDate,$endDate,$addChangeStartDate,$addChangeEndDate,
                      $withdrawStartDate,$withdrawEndDate,$memberSeq,$selected);


    $stmt->fetch();

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
	$conn->close();

?>