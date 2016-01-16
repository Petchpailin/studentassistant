<?php
    session_start();    
    $_SESSION['userid'] = 1;
    $memberID = 1;

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentAssistantDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
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
    <title>ContactFriend</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jasny-bootstrap.min.js"></script>
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">
</head>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', "tr.rowlink", function(){
            var friendSeq = $(this).children().children().val();  //get tel $('tr.rowlink').first().children().children().next().html();
            // console.log(friendSeq); //get name $('tr.rowlink').first().children().children().html();
            $.ajax({
                   method: "POST",
                   url: "editContactFriend.php",
                   cache: false,
                   data: "friendSeq="+friendSeq,
                   success: function(msg){
                     //alert( "Data Call : " + msg);
                     $('#editModalBody').replaceWith(msg);
                   }
             });
        });    

        $(document).on('click', "#add", function(){
            var friend = {
              'friendId': $('#frdId').val(),
              'name': $('#frdname').val(),
              'nickname': $('#frdnickname').val(),
              'tel': $('#frdtel').val(),
              'facebook': $('#frdfacebook').val(),
              'line': $('#frdline').val(),
              'email': $('#frdemail').val()
            };

            $.ajax({
                method: "POST",
                url: "insertContactFriend.php",
                data: {friend : JSON.stringify(friend)},
                success: function(msg){
                   //alert(msg);
                    $('#friendlist').replaceWith(msg);
                   
                    $('#myModal1').modal('hide');
                        
                }
            });   
        });

    $(document).on('click', "#del", function(){
        var x = $('#friendSeq').val();
        // console.log(x);

        var friend = {
              'friendSeq': $('#friendSeq').val(),
        };

        $.ajax({
                method: "POST",
                url: "deleteContactFriend.php",
                data: {friend : JSON.stringify(friend)},
                success: function(msg){
                   //alert(msg);
                   $('#friendlist').replaceWith(msg);
                   $('#myModal2').modal('hide');
                }
        });
    });

    $(document).on('click', "#update", function(){
         var friend = {
              'friendSeq': $('#friendSeq').val(),
              'friendId': $('#friendId').val(),
              'name': $('#name').val(),
              'nickname': $('#nickname').val(),
              'tel': $('#tel').val(),
              'facebook': $('#facebook').val(),
              'email': $('#email').val(),
              'line': $('#line').val()
        };

        $.ajax({
                method: "POST",
                url: "updateContactFriend.php",
                data: {friend : JSON.stringify(friend)},
                success: function(msg){
                   alert(msg);
                   $('#myModal2').modal('hide');
                }
        });
    });



});

</script>

<style type="text/css">

    @media only screen and (min-width: 0px) and (max-width: 679px) {
        .btn 
        {
            margin: 0;
            font-size:100%;
            line-height: 1;
            white-space: normal;
        }    
    }

    .iconEdit{
        float:right;
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
                <li>
                    <a href="showScheduleList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-calendar fa-stack-1x "></i></span> Schedule</a>
                </li>
                <li>
                    <a href="showGradeList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-graduation-cap fa-stack-1x "></i></span> Grade</a>
                </li>
                <li>
                    <a href="showAppointmentList.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-list-alt fa-stack-1x "></i></span> Appointment</a>
                </li>
                <li  class="active">
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
                        <h2><center>Contact List</center></h2>
                        </br>
                                               <span class = "iconEdit"><button type='button' class='btn btn-info btn-md' data-toggle='modal' data-target='#myModal1'>
                        Add Contact Friend</center></button>
                        </span>
                        </br>
                        <div id = 'friendlist'>
                        <table class='table table-hover'>

                        <?php 
                        $sql = "SELECT * FROM friend where member_seq = '".$memberID."' ORDER BY friend_nickname"; 
                        $result = mysqli_query($conn, $sql);
                        $alphabet = array();
                        $alphabet[0] = "";
                       

                        while($row = mysqli_fetch_assoc($result)) {
                            $i = 0;
                            $str = substr($row['friend_nickname'],0,1);
                            while($i < sizeof($alphabet)){
                                if($str !==  $alphabet[$i]){
                                    $alphabet[$i] = $str;
                                    echo "<th>".$str."</th>";
                                }
                                $i++;
                            }
                            echo "<tr class = 'rowlink' data-toggle='modal' data-target='#myModal2'><td><input type = 'hidden' value = '".
                            $row['friend_seq']."'> <span class = 'name'>".$row['friend_nickname']
                            ."</span><br><span id = 'frdTel'>".$row['friend_tel']."</span></td></tr>";
                        }
                        ?>
                        </table>
                        </div>
                        
                      

                         

           















                
                         <!-- Modal for Add Friend-->
                        <div class="modal fade" id="myModal1" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Friend</h4>
                                     </div>
                                    <div class="modal-body">
                                        StudentID <input id ='frdId' type = 'text'> </br>
                                        Name <input id = 'frdname' type ='text'> </br>
                                        Nickname <input id = 'frdnickname' type = 'text'> </br>
                                        Tel <input id = 'frdtel' type = 'text'> </br>
                                        Facebook <input id = 'frdfacebook' type = 'text'> </br>
                                        E-mail <input id = 'frdemail' type = 'text'> </br>
                                        Line <input id = 'frdline' type = 'text'> </br>
                                       
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" id = 'add' class="btn btn-default" data-dismiss="modal">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <!-- Modal for Edit Data Friend-->
                        <div class="modal fade" id="myModal2" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Contact</h4>
                                     </div>
                                    <div class="modal-body">
                                        <p id = 'editModalBody'>
                                       
                                          
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id = 'del' class="btn btn-default">del</button>
                                        <button type="button" id = 'update' class="btn btn-default">update</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>
</body>

</html>
