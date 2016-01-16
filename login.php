<?php
	session_start();
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

		$username = $_POST['username'];
		$password = $_POST['password'];

		echo $username;
		echo $password;

	$sql = "SELECT * FROM member WHERE member_username = '".mysql_real_escape_string($username)."' 
	and member_password = '".mysql_real_escape_string($password)."'";

	$objQuery = mysqli_query($conn,$sql);
	$objResult = mysqli_fetch_array($objQuery);

	if(!$objResult)
	{
			echo "Username and Password Incorrect!";
	}
	else
	{
			$_SESSION["memberSeq"] = $objResult["member_seq"];
			$_SESSION["memberUsername"] = $objResult["member_username"];

			session_write_close();

			echo "login Successfully";
			
			
			header("location:semesterDetail.php");
			
	}
}
	mysql_close();
?>
