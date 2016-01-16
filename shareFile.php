<?php
	session_start();
	$memberSeq = $_SESSION['memberSeq'];
	$fileSeq =  $_POST['fileSeq'];

    //echo $fileSeq;

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT * from file where member_seq ='".$memberSeq."' and filekey = '"
    .$fileSeq."'";
    $objQuery = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($objQuery)){
        echo "<input type ='hidden' id = 'fileSeq' value ='".$row['filekey']."'>";
        echo $row['file_title']."</br>";
        echo $row['file_detail']."</br>";
        echo "(".$row['file_name'].")";

    		// $appointment = array(
    		// 	'appointmentSeq'=> $row['appointment_seq'],
    		// 	'title'=> $row['appointment_title'],
    		// 	'description'=> $row['appointment_description'],
    		// 	'startDate'=> $row['appointment_start_date'],
    		// 	'endDate'=> $row['appointment_end_date'],
    		// 	'startTime'=> $row['appointment_start_time'],
    		// 	'endTime'=> $row['appointment_end_time']
    		// );

    }

    // print json_encode($appointment);
    mysqli_close($conn);
?>