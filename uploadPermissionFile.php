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
    $sql = "UPDATE file SET file_permission = 'public' where member_seq ='".$memberSeq."' and filekey = '"
    .$fileSeq."'";

     

    if (mysqli_query($conn, $sql)) {

        echo "changed to public";

    

    }

    // print json_encode($appointment);
    mysqli_close($conn);
?>