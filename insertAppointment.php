<?php
	session_start();
	$memberSeq =  $_SESSION['memberSeq'];
	$appointment =  $_POST['appointment'];
	$val = json_decode($appointment,true);
    //print_r($val);

	$servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";


	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);



	// //Check connection
	// if (!$conn) {
 //    	die("Connection failed: " . mysqli_connect_error());
	// }
	// else{
			
	$sql = "INSERT INTO appointment (appointment_title,appointment_description,appointment_start_date,
appointment_start_time,appointment_end_date,appointment_end_time,
member_seq)
	VALUES ('".$val['title']."','".$val['description']."','".$val['startDate']."','".$val['startTime']."','".$val['endDate']."','".
	$val['endTime']."','".$memberSeq."')";

	if (mysqli_query($conn, $sql)) {
    	//echo "New record created successfully";
        $sql = "SELECT * from appointment where member_seq ='".$memberSeq."'";
        $objQuery = mysqli_query($conn,$sql);
        $color = array("list-group-item list-group-item-success", "list-group-item list-group-item-info", "list-group-item list-group-item-warning","list-group-item list-group-item-danger");
        $i = 0;

             while($row = mysqli_fetch_assoc($objQuery)){
                $i = $i%4;
                echo "<a href = '#' class='".$color[$i]." appointment'>";
                echo "<input type ='hidden' class = 'appointSeq' value = '".$row['appointment_seq']."'>";
                echo $row['appointment_title']."</br>";
                $startDate = date("d M", strtotime($row['appointment_start_date']));
                $endDate = date("d M", strtotime($row['appointment_end_date']));
                $startTime = substr($row['appointment_start_time'],0,5);
                $endTime = substr($row['appointment_end_time'],0,5);
                echo $startDate." - ".$endDate;
                echo " ( ".$startTime."-".$endTime." ) </br> ";
                echo "</a>";
                $i = $i+1;
            }
    	
	} else {
    	//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
// }
	mysqli_close($conn);
?>
