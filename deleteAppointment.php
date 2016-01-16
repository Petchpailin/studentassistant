<?php
	session_start();    
    $memberSeq = $_SESSION['memberSeq'];
    $appointmentSeq = $_POST['appointmentSeq'];
	

	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname = "studentassistantDB";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	else{

		$sql = "DELETE FROM appointment WHERE appointment_seq ='".$appointmentSeq."'";

		if (mysqli_query($conn, $sql)) {
    		//echo "Record updated successfully";
    		$color = array("list-group-item list-group-item-success", "list-group-item list-group-item-info", "list-group-item list-group-item-warning","list-group-item list-group-item-danger");
            $i = 0;


    		 $sql = "SELECT * from appointment where member_seq ='".$memberSeq."'";
    		 $objQuery = mysqli_query($conn,$sql);

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
    		//echo "Error updating record: " . mysqli_error($conn);
		}
	}

		mysqli_close($conn);
?>