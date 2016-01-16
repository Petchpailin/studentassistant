<?php
if(isset($_GET['q'])){

	$seq =  $_GET['q'];


	$servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
 
    $sql = "SELECT * from subject where subject_seq = '".$seq."'";
    $result = mysqli_query($conn, $sql);
  

    $row = mysqli_fetch_assoc($result);
    $subjectSeq = $row['subject_seq'];
    $subjectCode = $row['subject_id'];
    $subjectName = $row['subject_name'];
    $subjectShortName = $row['subject_shortname'];
    $subjectSection = $row['subject_section'];

    //Teacher
    $sqlTeacher = "SELECT lecturer_name FROM lecturer INNER JOIN subject_lecturer ON lecturer.lecturer_seq 
    = subject_lecturer.lecturer_seq where subject_seq = ".$subjectSeq;
    $resultTeacher = mysqli_query($conn, $sqlTeacher);
    $rowTeacher = mysqli_fetch_assoc($resultTeacher);
    $teacherName= $rowTeacher['lecturer_name'];

    //class
    //$sqlClass = "SELECT * FROM schedule";
    $sqlClass = "SELECT * FROM schedule INNER JOIN subject ON subject.schedule_seq = schedule.schedule_seq where subject.subject_seq =".$subjectSeq;
    $resultClass = mysqli_query($conn, $sqlClass);
    $rowClass = mysqli_fetch_assoc($resultClass);
    $day = $rowClass['schedule_day'];
    $startTime = $rowClass['schedule_start_time'];
    $endTime = $rowClass['schedule_end_time'];
    $place = $rowClass['schedule_place'];
    $room = $rowClass['schedule_room'];

    // //examtable
    // $sqlExam= "SELECT * FROM examtable INNER JOIN subject ON subject.subject_seq =  examtable.subject_seq where examtable.subject_seq =".$subjectSeq;
    // $resultExam = mysqli_query($conn, $sqlExam);
    // $rowExam = mysqli_fetch_assoc($resultExam);
    // $examName = $rowExam['examtable_name'];
    // $examDate = $rowExam['examtable_date'];
    // $examStartTime = $rowExam['examtable_start_time'];
    // $examEndTime = $rowExam['examtable_end_time'];
    // $examPlace = $rowExam['examtable_place'];
    // $examRoom = $rowExam['examtable_room'];
    // $examSeat = $rowExam['examtable_seat'];



  

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Subject</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/studentAssistant.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default no-margin">
        <div class="navbar-header fixed-brand">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle"> <!-- responsive menu show here -->
                <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
            </button>
            <a class="navbar-brand" href="#"><i class="fa fa-rocket fa-4"></i> STUDENT</a>        
        </div>
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 
            <ul class="nav navbar-nav">
                <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button></li>
            </ul>  
        </div>
    </nav>

    <div id="wrapper">
         <div id="sidebar-wrapper">
                <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                <li id = 'term'>
                    <a href="semesterDetail.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-pencil-square-o fa-stack-1x "></i></span> Term 2/2015</a>     
                </li>
               
                <li class="active" >
                    <a href="showSubjectList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-flag fa-stack-1x "></i></span> Subject</a>
                </li>
                <li>
                    <a href="showScheduleList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar fa-stack-1x "></i></span> Schedule</a>
                </li>
                <li>
                    <a href="showGradeList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-graduation-cap fa-stack-1x "></i></span> Grade</a>
                </li>
                <li>
                    <a href="showAppointmentList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-list-alt fa-stack-1x "></i></span> Appointment</a>
                </li>
                <li>
                    <a href="showContactFriend.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-book fa-stack-1x "></i></span> Contact</a>
                </li>
                <li>
                    <a href="uploadPhotoAll.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-file fa-stack-1x "></i></span> Multimedia</a>
                </li>
                <li>
                    <a href="Search.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-search fa-stack-1x "></i></span> Search</a>
                </li>
                 <li>
                    <a href="PrototypeSetting.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-cog fa-stack-1x "></i></span> Setting</a>
                </li>
                 <li>
                    <a href="logout.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-sign-out fa-stack-1x "></i></span> Sign Out</a>
                </li>
            </ul>
        </div>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xs-12">

                        <!-- Edit Detail Of Subject   -->
                        <ul class="list-group">
                            <?php echo "<a href='subjectDelete.php?q=".$subjectSeq."' class='list-group-item list-group-item-success'>".$subjectCode." ".$subjectName." (".$subjectShortName.")"." SEC ".$subjectSection.
                            "<span class='glyphicon glyphicon-trash left' aria-hidden='true'></span>
                            </a>";   ?> 
                            
                        </ul> 


                        <!-- Edit Teacher -->
                        <div class="panel panel-info">
                        <!-- Default panel contents -->
                            <div class="panel-heading">Teacher </div>


                        <!-- List group -->
                            <ul class="list-group">
                                <li class="list-group-item"><?php echo $teacherName ?></li>  <!--section problem !-->
                            </ul>
                     
                        </div>


                          <!-- Edit Class -->
                        <div class="panel panel-info">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Class 
                            </div>
                            <!-- List group -->
                            <ul class="list-group">
                                <li class="list-group-item">
                                <?php echo $day." ".$startTime."-".$endTime." ".$place." ".$room;?>  
                            </li>
                            </ul>
                        </div>



                        <div class="panel panel-warning">
                        <!-- Default panel contents -->
                            <div class="panel-heading">Examtable  

                            </div>
                               

                      <!--   <!-- List group 
                        <ul class="list-group">


                        <li class="list-group-item"><?php echo $examName."</br>".$examDate."</br>".$examStartTime."</br>". 
                            $examEndTime."</br>". $examPlace."</br>".$examRoom."</br>".$examSeat; ?>
                        </li>

                           
                        </ul> -->
                        </div>








                         
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->

   </body>
   </html>