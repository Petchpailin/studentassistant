<?php
    session_start();
    $memberSeq = $_SESSION['memberSeq'];

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // prepare and bind
    $stmt = $conn->prepare("SELECT * FROM semester where member_seq = ? and semester_selected = '1'");
    $stmt->bind_param("s",$memberSeq); 

    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($id,$name,$year,$startDate,$endDate,$addChangeStartDate,$addChangeEndDate,
                      $withdrawStartDate,$withdrawEndDate,$memberSeq,$selected);


    $stmt->fetch();

    //convert data format to Day Month Year
     
    $idSemesterSelected = $id;
    $nameSemesterSelected = $name;
    $yearSemesterSelected = $year;
    $startDateSelected = date("d M Y", strtotime($startDate));
    $endDateSelected = date("d M Y", strtotime($endDate));;
    $addChangeStartDateSelected = date("d M Y", strtotime($addChangeStartDate));
    $addChangeEndDateSelected = date("d M Y", strtotime($addChangeEndDate));
    $withdrawStartDateSelected = date("d M Y", strtotime($withdrawStartDate));
    $withdrawEndDateSelected = date("d M Y", strtotime($withdrawEndDate));

    

    // $stmt->close();
    // $conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>semester</title>
   
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>  
    <script src="js/bootstrap3-typeahead.js"></script> 
    <script src="js/moment.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="css/bootstrap-clockpicker.min.css" />
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-clockpicker.min.js"></script>
     <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/studentAssistant.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
</head>
<script type="text/javascript">
$(document).ready(function(){

    function getSemester(){


        $.ajax({
                method: "GET",
                url: "selectSemester.php",
                success: function(msg){
                     //console.log(msg);
                     var data = JSON.parse(msg);
                     var x;
                     for (x in data) {
                        //console.log(data[x].id);
                        $('#semesterList').append("<option value = "+data[x].id+">"+data[x].name+
                                                      " / "+data[x].year+"</option>");
                        if(data[x].selected === '1'){
                            //console.log(data[x].name+" / "+data[x].year);
                            $("#semesterList option[value="+data[x].id+"]").attr('selected', true);
                        }
                    }

                }
        });


    }

    $('#add').click(function(){
        var startDate = $('#datepicker1').val();
        var endDate = $('#datepicker2').val();
        var addChangeStartDate = $('#datepicker3').val();
        var addChangeEndDate = $('#datepicker4').val();
        var withdrawStartDate = $('#datepicker5').val();
        var withdrawEndDate = $('#datepicker6').val();

       
        
        var startDateConvert = moment(new Date(startDate)).format("YYYY-MM-DD");
        var endDateConvert = moment(new Date(endDate)).format("YYYY-MM-DD");
        var addChangeStartDateConvert = moment(new Date(addChangeStartDate)).format("YYYY-MM-DD");
        var addChangeEndDateConvert = moment(new Date(addChangeEndDate)).format("YYYY-MM-DD");
        var withdrawStartDateConvert = moment(new Date(withdrawStartDate)).format("YYYY-MM-DD");
        var withdrawEndDateConvert = moment(new Date(withdrawEndDate)).format("YYYY-MM-DD");
     
        var name = $('#semestername').val();
        var year = $('#semesteryear').val();

        var semesterDetail = "<center>Semester "+name+" / "+year+"</br>"+
        "StartDate "+startDate+" - "+endDate+"</br>"+
        "Add & Change Date "+addChangeStartDate+" - "+addChangeEndDate+"</br>"+
        "Withdrawal Date "+withdrawStartDate+" - "+withdrawEndDate+"</center>";

        var term = {
            name: $('#semestername').val(),
            year: $('#semesteryear').val(),
            startDate: startDateConvert,
            endDate: endDateConvert,
            addChangeStartDate: addChangeStartDateConvert,
            addChangeEndDate: addChangeEndDateConvert,
            withdrawStartDate: withdrawStartDateConvert,
            withdrawEndDate: withdrawEndDateConvert
        };


        $.ajax({
                method: "POST",
                url: "insertSemester.php",
                data: {term : term},
                success: function(msg){
                     //console.log(msg);
                     $('#semesterList').append("<option value = "+msg+">"+name+" / "+year+"</option>");
                     $("#semesterList option[value="+msg+"]").attr('selected', true);
                     $('#datepicker1').val("");
                     $('#datepicker2').val("");
                     $('#datepicker3').val("");
                     $('#datepicker4').val("");
                     $('#datepicker5').val("");
                     $('#datepicker6').val("");
                     $('#semestername').val("");
                     $('#semesteryear').val("");

                     $("#semesterList option[value="+msg+"]").attr('selected', true);
                     var id = "<input type ='hidden' id = 'idselected' value = '"+msg+"'>";

                     $('.semesterDetail').html(id+semesterDetail);
                     $('#myModal').modal('hide');

                 

                }
        });

    });



    $('#datepicker1').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('#datepicker2').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('#datepicker3').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('#datepicker4').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('#datepicker5').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('#datepicker6').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

      $('#datepicker7').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

       $('#semesterList').change(function () {

        var val = $(this).val();
        alert('Do you want to Change Semester ?');
        //alert('changed to be'+val);
        $.ajax({
                method: "GET",
                url: "selectSemesterDetail.php",
                data : "semesterSeq="+val,
                success: function(msg){
                    console.log(msg);
                    var data = JSON.parse(msg);

                    
                    //$("#semesterList option:selected").remove();
                    $("#semesterList option[value="+data.id+"]").attr('selected', true);
                    var id = "<input type ='hidden' id = 'idselected' value = '"+data.id+"'>";
                    var semesterDetail = "<center>Semester "+data.name+" / "+data.year+"</br>"+
                    "StartDate "+data.startDate+" - "+data.endDate+"</br>"+
                    "Add & Change Date "+data.addChangeStartDate+" - "+data.addChangeEndDate+"</br>"+
                    "Withdrawal Date "+data.withdrawStartDate+" - "+data.withdrawEndDate+"</center>";

                    $('.semesterDetail').html(id+semesterDetail);
                    //  var data = JSON.parse(msg);
                    //  var x;
                    //  for (x in data) {
                    //     console.log(data[x].id);
                    //     // $('#semesterList').append("<option value = "+data[x].id+">"+data[x].name+
                    //     //                               " / "+data[x].year+"</option>");
                    //     // if(data[x].selected === '1'){
                    //     //     //console.log(data[x].name+" / "+data[x].year);
                    //     //     $("#semesterList option[value="+data[x].id+"]").attr('selected', true);
                    //     //}
                    // }

                }
        });

    });

   $('#del').click(function(){

        var semesterSeq = $('#idselected').val();

        console.log(semesterSeq);
      
        $.ajax({
                method: "GET",
                url: "deleteSemester.php",
                data: "semesterSeq="+semesterSeq,
                success: function(msg){
                    console.log(msg);
                    var data = JSON.parse(msg);

                    
                    //$("#semesterList option:selected").remove();
                    $("#semesterList option[value="+data.id+"]").attr('selected', true);
                    var id = "<input type ='hidden' id = 'idselected' value = '"+data.id+"'>";
                    var semesterDetail = "<center>Semester "+data.name+" / "+data.year+"</br>"+
                    "StartDate "+data.startDate+" - "+data.endDate+"</br>"+
                    "Add & Change Date "+data.addChangeStartDate+" - "+data.addChangeEndDate+"</br>"+
                    "Withdrawal Date "+data.withdrawStartDate+" - "+data.withdrawEndDate+"</center>";

                    $('.semesterDetail').html(id+semesterDetail);
                     
                 

                }
        });

    });
    
    $('#editSemesterDetail').click(function(){

        var semesterSeq = $('#idselected').val();

        console.log(semesterSeq);
      
        $.ajax({
                method: "GET",
                url: "selectSemesterDetail.php",
                data: "semesterSeq="+semesterSeq,
                success: function(msg){
                    console.log(msg);
                    var data = JSON.parse(msg);

                    
                    //$("#semesterList option:selected").remove();
                    // $("#semesterList option[value="+data.id+"]").attr('selected', true);
                    var id = "<input type ='hidden' id = 'idselected' value = '"+data.id+"'>";
                    // var semesterDetail = "<center>Semester "+data.name+" / "+data.year+"</br>"+
                    // "StartDate "+data.startDate+" - "+data.endDate+"</br>"+
                    // "Add & Change Date "+data.addChangeStartDate+" - "+data.addChangeEndDate+"</br>"+
                    // "Withdrawal Date "+data.withdrawStartDate+" - "+data.withdrawEndDate+"</center>";

                    $('#semesterDetailForUpdate').prepend(id);

                    $('#semesternameEdit').val(data.name);
                    $('#datepicker7').datepicker('update',data.startDate);
                    $('#myModal2').modal('show');
                     
                
                }
        });

    });


    $('#update').click(function(){
        var startDate = $('#datepicker7').val();
        var startDateConvert = moment(new Date(startDate)).format("YYYY-MM-DD");

        var semesterSeq = $('#idselected').val();
        var name = $('#semesternameEdit').val();

        var term = {
            semesterSeq : semesterSeq,
            name : name,
            startDate: startDateConvert
        };
      
        $.ajax({
                method: "POST",
                url: "updateSemester.php",
                data: {term : term},
                success: function(msg){
                    console.log(msg);
                    //var data = JSON.parse(msg);
                    $('#myModal2').modal('hide');
                     
                
                }
        });

    });


    getSemester();

});

</script>
<style type="text/css">

.semesterDropdown{
   display: block;
   float: left;
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
                <li  class="active" id = 'term'>
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
                    <div class="col-lg-2 col-xs-5">
                        <select class  = 'form-control' id = 'semesterList'></select>

                    </br>
                    </div>
                    <div class="col-lg-10 col-xs-7">
                        <button type='button'  class='btn btn-info btn-md left' data-toggle='modal' data-target='#myModal'>
                        Add Semester</center></button></br></br>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="jumbotron">
                                <div class = 'semesterDetail'>
                                <?php

                                    // $id,$name,$year,$startDate,$endDate,$addChangeStartDate,$addChangeEndDate,
                                    // $withdrawStartDate,$withdrawEndDate,$memberSeq,$selected

                                    
                                    echo "<input type ='hidden' id = 'idselected' value = '".$idSemesterSelected."'>";
                                    echo "<center>";
                                    printf("Semester %s / %s",$nameSemesterSelected ,$yearSemesterSelected );
                                    echo "</br>";
                                    printf("StartDate %s - %s", $startDateSelected,$endDateSelected);
                                    echo "</br>";
                                    printf("Add & Change Date %s - %s",$addChangeStartDateSelected,$addChangeEndDateSelected);
                                    echo "</br>";
                                    printf("Withdrawal Date %s - %s",$withdrawStartDateSelected,$withdrawEndDateSelected);
                                    echo "</center>";





                                ?>
                                </div>

                        <button type='button'  class='btn btn-info btn-md' id = 'editSemesterDetail'>
                        Edit Semester</center></button>

                        <button type='button'  class='btn btn-info btn-md' id='del'>
                        Delete Semester</center></button></br></br>


               






                       
                            </p>
                            </div>
                            <div class="alert alert-danger" role="alert"><center>

                       
                            </center></div>

                </div>
                       
                       
                         <div class="modal" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Semester</h4>
                                     </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                Name <input type = 'text' class="form-control" id = "semestername"> </br>
                                            </div>
                                        <div class="col-lg-6">
                                            Year <input type = 'text' class="form-control" id = "semesteryear"> </br>
                                        </div>

                                        </div>


                                    <div class="row">
                                        <div class="col-lg-6">
                                            Start Date<input type='text' class="form-control" id='datepicker1' />
                                        </div><!-- /.col-lg-6 -->
                                        <div class="col-lg-6">  
                                            End Date<input type='text' class="form-control" id='datepicker2' />
                                        </div>
                                    </div>
                                 
                                    <div class="row">
                                        <div class="col-lg-6">
                                            Add & Change Start Date<input type='text' class="form-control" id='datepicker3' />
                                        </div><!-- /.col-lg-6 -->
                                        <div class="col-lg-6">  
                                            Add & Change End Date<input type='text' class="form-control" id='datepicker4' />
                                        </div>
                                     </div>

                                     <div class="row">
                                        <div class="col-lg-6">
                                            Withdrawal Start Date<input type='text' class="form-control" id='datepicker5' />
                                        </div><!-- /.col-lg-6 -->
                                        <div class="col-lg-6">  
                                            Withdrawal End Date<input type='text' class="form-control" id='datepicker6' />
                                        </div>
                                     </div>


     
                   
                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id='add' class="btn btn-default">Add</button>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class="modal" id="myModal2" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Semester</h4>
                                     </div>
                                    <div class="modal-body">
                                        <div id = 'semesterDetailForUpdate'>
                                                <div class="row">
                                            <div class="col-lg-6">
                                            Name <input type = 'text' class="form-control" id = "semesternameEdit"> </br>
                                            </div>
                        
                                        </div>


                                    <div class="row">
                                        <div class="col-lg-6">
                                            Start Date<input type='text' class="form-control" id='datepicker7' />
                                        </div><!-- /.col-lg-6 -->
                                        
                                    </div>
                                 
                      
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id='update' class="btn btn-default">Edit</button>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>











                        
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    

</body>

</html>
