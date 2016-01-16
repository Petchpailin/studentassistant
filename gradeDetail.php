<?php
session_start();

if(isset($_GET['q'])){

	$name =  $_GET['q'];
    $memberSeq = $_SESSION['memberSeq'];


	$servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
 
    $sql = "SELECT * from subject where subject_seq = '".$name."'";
    $result = mysqli_query($conn, $sql);
  

    $row = mysqli_fetch_assoc($result);
    $subjectSeq = $row['subject_seq'];
    $subjectCode = $row['subject_id'];
    $subjectName = $row['subject_name'];
    $subjectShortName = $row['subject_shortname'];

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
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>  
    <script src="js/bootstrap3-typeahead.js"></script> 
</head>
<script>


$(document).ready(function() {
    $(document).on('click', "#update", function(){
        var grade = {
            subject:$('#subjectseq').val(),
            grade:$('#gradelist :selected').text()
        };

        $.ajax({
                method: "POST",
                url: "updateGrade.php",
                data: {grade : JSON.stringify(grade)},
                success: function(msg){
                  
                   $('#grade').html(msg);
                   $('#myModal').hide();

                }
        });
    });

      $(document).on('click', "#updateScore", function(){
        //  // var f = $('#showscore' ).find( '.scoreseq' ); 
        // //  // alert(f);
        //  $('#showscore' ).find( '.seq' ).each(function(){
        //         var x = $(this);
        //         //var y = x.val();
        //         if(x.val() == 39){
        //             //var z = $(this).next().html("PETCH");
        //             var z = $(this).next().hide();
        //             alert(z);
        //         }
            
        // });
        // var x = $('#showscore' ).find( '.seq' ).val();
        // alert(x);
        var score = {
            scoreSeq: '34',
            marks: '2',
            fullmarks: '500'
        };

        $.ajax({
                method: "POST",
                url: "updateScore.php",
                data: {score : JSON.stringify(score)},
                success: function(msg){
                    //alert(msg);
                   
                    $('#showscore').html(msg);
                  
                   // $('#grade').html(msg);
                   $('#myModal2').modal('hide');

                }
        });
    });



    $(document).on('click', "#add", function(){
        var score = {
            subject: '1',
            scorename:$('#scorename').val(),
            marks:$('#marks').val(),
            fullmarks:$('#fullmarks').val()
        };

        $.ajax({
                method: "POST",
                url: "insertScore.php",
                data: {score : JSON.stringify(score)},
                success: function(msg){
                    //alert(msg);
                    $('#showscore').html(msg);
                    $('#scorename').val("");
                    $('#marks').val("");
                    $('#fullmarks').val("");
                    $('#myModal1').hide();

                }
        });
    });

     $(document).on('click', "#del", function(){
        var score = {
            scoreSeq: '38',       
        };

        $.ajax({
                method: "POST",
                url: "deleteScore.php",
                data: {score : JSON.stringify(score)},
                success: function(msg){
                    //alert(msg);
                    $('#showscore').html(msg);
                     $('#myModal2').modal('hide');
                }
        });
    });

    $(document).on('click', ".test", function(){
        //$( this ).find( '.scoreseq' ).val() 
        
        var score = {
            
            scoreseq: '1'      
        };

        $.ajax({
                method: "POST",
                url: "showScore.php",
                data: {score : JSON.stringify(score)},
                success: function(msg){
                    var x = JSON.parse(msg);
                    //alert(x.scoreSeq);
                    $('#editType').val(x.scoreSeq);
                    $('#editMarks').val(x.scoreType);
                    $('#editFullmarks').val("100");
                    // $('#scoreedit').html(msg);
                    $('#myModal2').modal('show');

                }
        });  
    });


 

});
</script>

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
                <li  class="active" >
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
                            <?php echo "<a href='subjectDelete.php?q=".$subjectSeq."' class='list-group-item list-group-item-success'>"."(".$subjectSeq.") ".$subjectCode." ".$subjectName." (".$subjectShortName.")".
                            
                            "</a>";   ?> 
                            
                        </ul> 

                        <ul class="list-group">
                                <a href = '#' data-toggle="modal" data-target="#myModal" class="list-group-item list-group-item-info">
                                    <?php
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = "password";
                                        $dbname = "studentassistantDB";
                                        $conn = mysqli_connect($servername, $username, $password, $dbname);

                                        $sql = "SELECT grade FROM member_subject where subject_seq ='".$subjectSeq."' and member_seq = '".$memberSeq."'";
                                        $result = mysqli_query($conn, $sql);

                                        if(mysqli_num_rows($result) > 0){
                                            $row = mysqli_fetch_assoc($result);
                                            echo "GRADE ";
                                            echo "<span id = 'grade'>";
                                            echo $row['grade'];
                                            echo "</span>";

                                        }
                                        else{
                                            echo "GRADE";
                                        }
                                    ?>
                                    <span class="glyphicon glyphicon-pencil left" aria-hidden="true"></span></a>
                        </ul>

                        <div class="panel panel-info">
                            <!-- List group -->
                            <ul class="list-group">
                                <a href = '#' data-toggle="modal" data-target="#myModal1" class="list-group-item list-group-item-info">SCORE 
                                <span class="glyphicon glyphicon-plus left" aria-hidden="true"></span></a>
                            </ul>
                            <div id = 'showscore'>
                            <?php

                            $sql = "SELECT * FROM score where member_subject_seq = '1' "; 
                            $result = mysqli_query($conn, $sql);
                            echo "<ul class='list-group'>";
        
                            if(mysqli_num_rows($result) > 0){
                                while ($row = mysqli_fetch_assoc($result)){
                                    echo "<a href = '#' class='list-group-item test'>";
                                   // echo "<span id ='scoredetail'>";
                                    echo $row['score_seq']." ";
                                    echo "<input type ='hidden' class ='seq'";
                                    echo "value =".$row['score_seq'].">";
                                    echo "<span class = 'name'>".$row['score_type']."</span><br>";
                                    echo "<span class = 'mark'>".$row['score_marks']."</span> / <span class = 'fullmark'>".$row['score_fullmarks']."</span><br>";
                                   // echo "</span>";
                                    echo "</a>";
                                }
                            }
                            echo "</ul>";
                            
                            ?>    
                            </div>
                            
                    
                        </div>
                      
                        </br>
                        </br>

                         <div class="modal" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Grade</h4>
                                     </div>
                                    <div class="modal-body">
                                    <?php echo "<input type = 'hidden' id = 'subjectseq' value = '".$subjectSeq."'>";  ?>    
                                        
                                    Grade<select id = 'gradelist'>
                                        <option value="A">A</option>
                                        <option value="B+">B+</option>
                                        <option value="B">B</option>
                                        <option value="C+">C+</option>
                                        <option value="C">C</option>
                                        <option value="D+">D+</option>
                                        <option value="F">F</option>

                                    </select> 
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id = 'update' class="btn btn-default">submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- add score -->
                        <div class="modal" id="myModal1" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Score</h4>
                                     </div>
                                    <div class="modal-body">
                                     <?php echo "<input type = 'hidden' id = 'subjectseq' value = '".$subjectSeq."'>";  ?>      
                                    score name<input type = 'text' id = 'scorename'><br>
                                    marks <input type = 'text' id = 'marks'>/<input type = 'text' id ='fullmarks'>
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id = 'add' class="btn btn-default">submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- edit score -->
                        <div class="modal" id="myModal2" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Score</h4>
                                     </div>
                                    <div class="modal-body">
                                        
                                    <!-- <div id = 'scoreedit'></div> -->
                                    score name<input type = 'text' id = 'editType'><br>
                                    marks <input type = 'text' id = 'editMarks'>/<input type = 'text' id ='editFullmarks'>
                                            
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id = 'del' class="btn btn-default">del</button>
                                        <button type="submit" id = 'updateScore' class="btn btn-default">update</button>
                                    </div>
                                </div>
                            </div>
                        </div>



    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->

   </body>
   </html>