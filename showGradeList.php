<?php
    session_start();
    // $_SESSION['userid'] = '1'; //give the example of userid
    // $_SESSION['term'] = '1'; //give the example of semester
    // $_SESSION['year'] = '2015'; //give the example of year semester
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Grade</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/studentAssistant.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>  
    <script src="js/bootstrap3-typeahead.js"></script> 
</head>
<style type="text/css">
.text{
    height: 30px;
    border-radius: 2px;
    border: 1px solid #e9e8e8;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    width: 100%;
    height: 50%;
    background: #fff;
}

.tag{
    margin-right: 2px;
    background-color: #CEECF5 ;
    height: 10%;
    width: 100%;
    float: left;
}

.text input{
     border: 0;
}

.delete{
    display : block;
    float: right;
    background: #81BEF7;
}
</style>

<script type="text/javascript">
    $(document).ready(function() {
        
});
</script>
<body>
    <?php  
        //include("connectDatabase.php"); //connect Database  
        //connectDatabase();
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentAssistantDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
   
    //$sql = 'select * from subject';
    $memberID =  1;
    $sql = "SELECT * FROM subject INNER JOIN member_subject ON subject.subject_seq = member_subject.subject_seq where member_seq = '".$memberID."'";
    $result = mysqli_query($conn, $sql);
    ?>
    
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
                <li>
                    <a href="showScheduleList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar fa-stack-1x "></i></span> Schedule</a>
                </li>
                <li class="active">
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
                        <h2><center>Grade & Score</center></h2>
                        <p align = 'left'>
                            
                            </br>
                            Term 1/2015
                        </p>
                        <ul class="list-group" id = 'myList'>
                            <?php 
                    

                            $color = array("list-group-item list-group-item-success", "list-group-item list-group-item-info", "list-group-item list-group-item-warning","list-group-item list-group-item-danger");
                            $i = 0;
                            while($row = mysqli_fetch_assoc($result)) {
                                $i = $i%4;
                                // echo "<button type='button' value ='".$row["subject_seq"]."'class='btn btn-default btn-sm del' >
                                //     <span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";
                                echo "<a href='gradeDetail.php?q=".$row['subject_seq']. "' class='".$color[$i]."'>".strtoupper($row['subject_name']).""."<span class='glyphicon glyphicon-pencil left' aria-hidden='true'></a>";  


                                //echo "<a href='subjectDetail.php?q=".$row['subject_name']. "' class='".$color[$i]."'>".strtoupper($row['subject_name']).""."<span class='glyphicon glyphicon-pencil left' aria-hidden='true'></a>";  
                                $i++;
                            } 
                            ?>
                          
                       
                        </ul>

                    
                <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Subject</h4>
                                     </div>
                                    <div class="modal-body">
                                        
                                            Subject <div class = 'text'> 
                                            <input id = 'subjectName' data-provide="typeahead" type = 'text' name = "subjectName" placeholder = 'Enter SubjectID or SubjectName' autocomplete = 'off' size = '30'> 
                                            </div>
                                            </br>
                                            Teacher <input id = 'teacher' data-provide="typeahead" type = 'text' name = "subjectName" autocomplete = 'off' disabled> </br>
                                            <input type="hidden" id="seq" name="seq" />
                                          <!--  TeacherSearch <input id = 'teacherSearch' data-provide="typeahead" type = 'text' name = "teacherSearch" autocomplete = 'off' size = '30'> </br>
                                            <div id = 'subjectList'> <ul> <li> </li> </ul> </div>  -->
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id = 'add' class="btn btn-default">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
 
        </div>
        <!-- /#page-content-wrapper -->
    </div> 

</body>
</html>