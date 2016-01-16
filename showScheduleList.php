<?php
    session_start();
    $memberSeq =  $_SESSION['memberSeq'];
   
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT subject.subject_name,schedule.* FROM member_subject INNER JOIN subject ON subject.subject_seq = member_subject.subject_seq INNER JOIN schedule ON subject.schedule_seq = schedule.schedule_seq where member_seq ='".$memberSeq."' ORDER BY FIELD(schedule_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),schedule_start_time";
    $result = mysqli_query($conn,$sql);
   
    $day = "day";
    // if(mysqli_num_rows($result) > 0){
    //     while($row = mysqli_fetch_assoc($result)){
    //         // echo $row['schedule_day']."</br>";
    //         // echo $row['subject_name']."</br>";
    //         $startTime = substr($row['schedule_start_time'],0,5);
    //         $endTime = substr($row['schedule_end_time'],0,5);
    //         // echo $startTime." - ".$endTime."</br>";
           
            
            
    //         if($day !== $row['schedule_day']){
    //             echo $row['schedule_day']."</br>";
    //             $day = $row['schedule_day'];
    //         }
    //         echo $row['subject_name']."</br>";
    //         echo $startTime." - ".$endTime."</br>";

            
    //     }
    // }
    // else { 
    //         echo "empty";
    // }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Semester</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
</head>

<script type="text/javascript">
$(document).ready(function(){

    $('#btnList').click(function(){
        window.location.href = "showScheduleList.php";
    });

    $('#btnCalendar').click(function(){
        window.location.href = "showScheduleTable.php";
    });

});

   
</script>

<style>

#tabColor{
    width: 8px;
    height: 55px;
    background-color: red;
    float: left;
    margin-right: 7px;
}
#tabColor1{
    width: 8px;
    height: 55px;
    background-color: blue;
    float: left;
    margin-right: 7px;
}

#tabColor2{
    width: 8px;
    height: 55px;
    background-color: pink;
    float: left;
    margin-right: 7px;
}


</style>

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
               
                <li>
                    <a href="showSubjectList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-flag fa-stack-1x "></i></span> Subject</a>
                </li>
                <li class="active">
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
                    <div class="col-lg-12">
                    <center>
                        <button type="button" class="btn btn-default " id= 'btnCalendar'>
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-default id = 'btnList">
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 
                        </button>
                    </center>
                    </br></br>


<?php
    $color = array('active','success','warning','danger','info');
    $i = 0;
    echo "<table class='table table-bordered'>";
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            // echo $row['schedule_day']."</br>";
            $i = $i%5;
            // echo $row['subject_name']."</br>";
            $startTime = substr($row['schedule_start_time'],0,5);
            $endTime = substr($row['schedule_end_time'],0,5);
            // echo $startTime." - ".$endTime."</br>";
           
            
            
            if($day !== $row['schedule_day']){
                echo "<tr class = '".$color[$i]."'><td>";
                echo $row['schedule_day']."</br>";
                echo "</td></tr>";
                $day = $row['schedule_day'];
            }
            echo "<tr><td>";
            echo $row['subject_name']."</br>";
            echo $startTime." - ".$endTime."</br>";
            echo $row['schedule_place']." ".$row['schedule_room'];
            echo "</td></tr>";


            $i = $i+1;

            
        }
    }
    else { 
            echo "Empty Added Subject";
    }
    echo "</table>";    
?>
















<!-- <table class="table table-bordered">
    <th>Monday
</table>
 -->



<!-- 
                       <p> Monday</p>
                        <ul class="list-group">
 
  <li class="list-group-item"><div id = 'tabColor1'></div> Data Mining </br>
     601/3</br>
     08.00 AM - 10.00 AM
</li>

</ul>
              

<p>Tuesday</p>
                        <ul class="list-group">
  

  <li class="list-group-item"><div id = 'tabColor2'></div>SA </br>
    102</br>
    11.00 AM - 01.00 PM</li>
</ul>

<p>Friday</p>
                        <ul class="list-group">
  

  <li class="list-group-item"><div id = 'tabColor2'></div>Seminar </br>
    102</br>
    03.00 PM - 05.00 PM</li>
</ul> -->



        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>
</body>

</html>
