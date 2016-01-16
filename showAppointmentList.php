<?php
    session_start();
    $memberSeq =  $_SESSION['memberSeq'];
   
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT * from appointment where member_seq ='".$memberSeq."'";
    $objQuery = mysqli_query($conn,$sql);
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
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/moment.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="css/bootstrap-clockpicker.min.css" />
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-clockpicker.min.js"></script>

    
</head>
<script type="text/javascript">
 $(document).ready(function() {
    $('#datepicker1').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('.clockpicker1').clockpicker({
        placement: 'auto',
        align: 'right',
    });

       $('#datepicker2').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('.clockpicker2').clockpicker({
        placement: 'top',
        align: 'right',
    });

    /************date and clock of modalEdit********************/
    $('#datepicker3').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('.clockpicker3').clockpicker({
        placement: 'auto',
        align: 'right',
    });

       $('#datepicker4').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('.clockpicker4').clockpicker({
        placement: 'top',
        align: 'right',
    });

    /**********************************************/


    $('#add').click(function(){
        var startDate = $('#datepicker1').val();
        var startDateConvert = moment(new Date(startDate)).format("YYYY-MM-DD");
        var endDate = $('#datepicker2').val();
        var endDateConvert = moment(new Date(endDate)).format("YYYY-MM-DD");
        console.log("startDate = "+startDateConvert+" endDate = "+endDateConvert);
        
        var appointment = {
            title: $('#title').val(),
            description: $('#description').val(),
            startDate: startDateConvert,
            endDate: endDateConvert,
            startTime: $("#startTime").val(),
            endTime: $("#endTime").val()

        };


        $.ajax({
                method: "POST",
                url: "insertAppointment.php",
                data: {appointment : JSON.stringify(appointment)},
                success: function(msg){
                    $('#showAppointment').html(msg);
                    $('#myModal').modal('hide');
                    $('#title').val("");
                    $('#description').val("");
                    $('#datepicker1').val("");
                    $('#datepicker2').val("");
                    //alert(msg);
                }
        });
    });

   // $('#myModal1').on('shown.bs.modal', function (e) {
  //       alert("modal show");

  //   })   
    $(document).on('click', ".appointment", function(){
        var appointSeq = $(this).find('.appointSeq').val();

        $.ajax({
                method: "POST",
                url: "selectAppointment.php",
                data: "appointSeq="+appointSeq,
                success: function(msg){
                    var data = JSON.parse(msg);
                    var startDateConvert = moment(new Date(data.startDate)).format("DD MMM YYYY");
                    var endDateConvert = moment(new Date(data.endDate)).format("DD MMM YYYY");
                    var startTimeSub = data.startTime.substr(0,5);
                    var endTimeSub = data.endTime.substr(0,5);
                    //alert(data.title);
                    $(".appointSeqEdit").val(data.appointmentSeq);
                    $('#titleEdit').val(data.title);
                    $('#descriptionEdit').val(data.description);
                    $('#datepicker3').datepicker('update',startDateConvert);
                    $('#datepicker4').datepicker('update',endDateConvert);
                    $("#startTimeEdit").val(startTimeSub);
                    $("#endTimeEdit").val(endTimeSub);
                    $("#myModal1").modal('show');
                }
        });

    });


    $(document).on('click', "#update", function(){
        var startDate = $('#datepicker3').val();
        var startDateConvert = moment(new Date(startDate)).format("YYYY-MM-DD");
        var endDate = $('#datepicker4').val();
        var endDateConvert = moment(new Date(endDate)).format("YYYY-MM-DD");

        var appointment = {
            appointmentSeq: $('.appointSeqEdit').val(),
            title:  $('#titleEdit').val(),
            description: $('#descriptionEdit').val(),
            startDate: startDateConvert,
            endDate: endDateConvert,
            startTime: $("#startTimeEdit").val(),
            endTime: $("#endTimeEdit").val()
        }

        $.ajax({
                method: "POST",
                url: "updateAppointment.php",
                data: {appointment : JSON.stringify(appointment)},
                success: function(msg){
                    //alert(msg);
                    $('#showAppointment').html(msg);
                    $("#myModal1").modal('hide');
                }
        });

    });


    $(document).on('click', "#delete", function(){
        var appointmentSeq = $('.appointSeqEdit').val();


        $.ajax({
                method: "POST",
                url: "deleteAppointment.php",
                data: "appointmentSeq="+appointmentSeq,
                success: function(msg){
                    //alert(msg);
                    $('#showAppointment').html(msg);
                    $("#myModal1").modal('hide');
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

    .colorClass{
        background-color: pink;
    }

    a { color: inherit; } 

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
                <li class="active">
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
                        <button type='button' id = 'update' class='btn btn-default btn-md update'>
                                <span class='glyphicon glyphicon-calendar' aria-hidden='true'></span>
                        </button>
                        <span class = "iconEdit"><button type='button' class='btn btn-info btn-md' data-toggle='modal' data-target='#myModal'>
                        Add Appointment</center></button></span>
                        <br><br>

                    <ul class="list-group" id ='showAppointment'>
                        <?php
                            $color = array("list-group-item list-group-item-success", "list-group-item list-group-item-info", "list-group-item list-group-item-warning","list-group-item list-group-item-danger");
                            $i = 0;
                            if(mysqli_num_rows($objQuery) > 0){
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
                            }
                            else { 
                                    echo "keeping your events";
                            }
                        ?>
                                
                                
                            </ul>
                        </div>

<!-- <li class="list-group-item list-group-item-success"><a href = '#' data-toggle='modal' data-target='#myModal'>Project Meeting </br>28 Oct (9.00 AM - 10.00 AM )</a> <span class = 'iconEdit'></span></li>
                                <li class="list-group-item list-group-item-info">Retrospective </br>29 Oct (06.30 PM - 07.00 PM) <span class = 'iconEdit'></span></li> -->

                        <div class="modal" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Appointment</h4>
                                     </div>
                                    <div class="modal-body">
                                    
                                            Title <input type = 'text' class="form-control" id = "title"> </br>
                                            Description <input type = 'text' class="form-control" id='description'> </br>
                                            <div class="row">
                                        <div class="col-xs-6">
                                     Start Date<input type='text' class="form-control" id='datepicker1' />
                                      </div><!-- /.col-lg-6 -->
                                            <div class="col-xs-6">  
                                     Start Time <div class="input-group clockpicker1" data-placement="left" data-align="top" data-autoclose="true">
                                     
                                        <input type="text" class="form-control" id ='startTime' value="00:00">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                     End Date<input type='text' class="form-control" id='datepicker2' />
                                      </div><!-- /.col-lg-6 -->
                                            <div class="col-xs-6">  
                                     End Time <div class="input-group clockpicker2" data-placement="left" data-align="top" data-autoclose="true">
                                     
                                        <input type="text" class="form-control" id ='endTime' value="00:00">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        </div>
                                      </div>
                                    </div>

                   
                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id='add' class="btn btn-default">Add</button>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>



    <!--modal for update / detail appointment-->
                        <div class="modal" id="myModal1" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Appointment Detail</h4>
                                     </div>
                                    <div class="modal-body">
                                            <input type = 'hidden' class = 'appointSeqEdit' value ="">
                                    
                                            Title <input type = 'text' class="form-control" id = "titleEdit"> </br>
                                            Description <input type = 'text' class="form-control" id='descriptionEdit'> </br>
                                            <div class="row">
                                        <div class="col-xs-6">
                                     Start Date<input type='text' class="form-control" id='datepicker3' />
                                      </div><!-- /.col-lg-6 -->
                                            <div class="col-xs-6">  
                                     Start Time <div class="input-group clockpicker3" data-placement="left" data-align="top" data-autoclose="true">
                                     
                                        <input type="text" class="form-control" id ='startTimeEdit' value="00:00">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                     End Date<input type='text' class="form-control" id='datepicker4' />
                                      </div><!-- /.col-lg-6 -->
                                            <div class="col-xs-6">  
                                     End Time <div class="input-group clockpicker4" data-placement="left" data-align="top" data-autoclose="true">
                                     
                                        <input type="text" class="form-control" id ='endTimeEdit' value="00:00">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                        </div>
                                      </div>
                                    </div>

                   
                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id='delete' class="btn btn-default" aria-label>Delete</button>
                                        <button type="button" id='update' class="btn btn-default">Update</button>
                                      
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
