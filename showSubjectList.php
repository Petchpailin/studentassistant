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
    $sql = "SELECT subject.* , member_subject.* FROM member_subject INNER JOIN subject ON subject.subject_seq = member_subject.subject_seq where member_seq ='".$_SESSION['memberSeq']."'";
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
    <link href="css/studentAssistant.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sidebar_menu.js"></script>  
    <script src="js/bootstrap3-typeahead.js"></script> 

</head>
<style>

/*#btnsubjectid.active{
     background-color: limegreen;
}
*/

</style>

<script type="text/javascript">
    $(document).ready(function() {
        
     
        $('#subjectName').typeahead({
            source:function(data,process){ //call server to send data
                $.get('searchSubject.php?q='+$('#subjectName').val(),function(data){
                    var subjectCode = $('#subjectName').val();
                    var data_json = JSON.parse(data);
                    process(data_json); //callback fx to parseJSON
                    console.log(data_json);
                   
                });
            },
            autoSelect: true,
            minLength: 1,
            updater: function (item) {
                $('#subjectDetail').show();
                //$('#subjectName').addClass("tag");
                var x = "<div class = 'tag'>"+item.subjectName+"<a class='delete'> DEL</a></div>";
                //$(x).insertBefore('#subjectName');
                // $('#subjectName').val("");
                // $('#subjectName').hide();
                //$('#subjectName').val("");
                $('#subjectSeq').val(item.subjectSeq);
                $('#teacher').val(item.teacher);
                //$('#section').val(item.qtyseq);
                $('#section').html("");
                for(var i = 1 ; i<= item.qtyseq;i++){
                    $('#section').append("<option>"+i+"</option>");
                }
                // $("input[id=seq]").val(item.subjectSeq);
                return item.subjectName;
            },
            displayText: function(item){

                    return item.subjectName;
            }
        });


        
     
        // $('#subjectId').typeahead({
        //     source:function(data,process){ //call server to send data
        //         $.get('searchSubjectId.php?q='+$('#subjectId').val(),function(data){
        //             var subjectCode = $('#subjectName').val();
        //             var data_json = JSON.parse(data);
        //             process(data_json); //callback fx to parseJSON
        //             console.log(data_json);
                   
        //         });
        //     },
        //     autoSelect: true,
        //     minLength: 1,
        //     updater: function (item) {
        //         $('#subjectDetail').show();
        //         //$('#subjectName').addClass("tag");
        //         var x = "<div class = 'tag'>"+item.subjectName+"<a class='delete'> DEL</a></div>";
        //         //$(x).insertBefore('#subjectName');
        //         // $('#subjectName').val("");
        //         // $('#subjectName').hide();
        //         //$('#subjectName').val("");
        //         $('#subjectSeq').val(item.subjectSeq);
        //         $('#teacher').val(item.teacher);
        //         //$('#section').val(item.qtyseq);
        //         $('#section').html("");
        //         for(var i = 1 ; i<= item.qtyseq;i++){
        //             $('#section').append("<option>"+i+"</option>");
        //         }
        //         // $("input[id=seq]").val(item.subjectSeq);
        //         return item.subjectName;
        //     },
        //     displayText: function(item){

        //             return item.subjectName;
        //     }
        // });
 


    // $(document).on('click', '.delete', function () {
    //     $(this).parent().remove();
    //     $('#subjectName').show();
    //     $('#teacher').val("");
    //     $('#section').children().remove();
    // });
    
    $( ".close" ).click(function() {
        $('.delete').parent().remove();
        $('#subjectName').show();
        $('#teacher').val("");
    });

    $( "#add" ).click(function() { // must be post 
        $('#modalAddSubject').modal('hide');
        var seq = $('#subjectSeq').val();
        //alert(seq);
      
        //alert(param);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            //location.reload();
            //alert(xhttp.responseText);
            var data = JSON.parse(xhttp.responseText);
            
            $('#myList').append("<a href='subjectDetail.php?q="+data.subjectSeq+"' class = 'list-group-item list-group-item-success'>"+data.subjectName+"</a>");
            //$('.delete').parent().remove();
            $('#subjectName').val("");
            $('#teacher').val("");
            }
        }
        xhttp.open("GET", "insertSubjectUser.php?q="+seq, true);
        xhttp.send();   
    });

    // $('#searchtype li').on('click', function(){
    //     var option = $(this).text();
    //     $('#searchChoose').text($(this).text());
    //     // $('#subjectName').val($(this).text());
    //     //alert(option);
    //     // if(option == 'Teacher'){
    //     //     autocomplete('searchTeacher');
    //     //     alert('teacher');
    //     // }
    //     // else{
    //     //     autocomplete('searchSubject');
    //     // }

        
    // });
    $('#section').change(function () {
        // var txt = $('.tag').text();
        // var res = txt.length;



        // var subtxt = txt.substring(0, res-3); 
        var subtxt = $('#subjectName').val();
        //alert(subtxt);
        var sec = this.value;

        var subject = {
            subjectName: subtxt,
            section: sec
        };


        $.ajax({
                method: "POST",
                url: "searchTeacherSec.php",
                data: {subject : JSON.stringify(subject)},
                success: function(msg){
                    var data = JSON.parse(msg);
                    $('#teacher').val(data.teacher);
                    $('#subjectSeq').val(data.subjectSeq);

                 

                }
        });

    });

    // $('#modalAddSubject').on('shown.bs.modal', function (e) {
    //     //$('#sec').hide();
    //      autocomplete('searchSubject');

    // })

    $(".btn-group > .btn").click(function(){
        $(this).addClass("active").siblings().removeClass("active");
    });

    $('#btnsubjectname').click(function(){
        // $('#subjectName').val("");
        // $('#subjectDetail').hide();
        $('#subjectName').attr("placeholder", "Enter Subject Name");
        // $('#subjectName').show();
        // $('#subjectId').hide();
        
    });  


    // $('#btnsubjectid').click(function(){
    //     // $('#subjectId').val("");
    //     // $('#subjectDetail').hide();
    //     $('#subjectId').attr("placeholder", "Enter SubjectId");
    //     $('#subjectName').hide();
    //     $('#subjectId').show();

   
    // });      


$('#btnsubjectname').click();
$('#subjectDetail').hide();
    

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
                        <h2><center>Subject</center></h2>
                        <p align = 'left'>
                            <span class = "left"><button type='button' class='btn btn-info btn-md' data-toggle='modal' data-target='#modalAddSubject' >
                            Add Subject</center></button>
                            </span>
                            </br>
                            Term 1/2015
                        </p>
                        
                        <div class="list-group" id='myList'>
                        <?php
                            if(mysqli_num_rows($objQuery) > 0){
                                while($row = mysqli_fetch_array($objQuery))
                                {
                                    echo "<a href='subjectDetail.php?q=".$row['subject_seq']."'";
                                    echo "class='list-group-item list-group-item-success'>";
                                    echo $row['subject_name'];
                                    echo "</a>";
                                }
                            }
                            else { 
                                echo "<div class='panel panel-default'>
                                <div class='panel-body'>";
                                echo "<center>Push Button above for Adding Subject</center>";
                                echo "</div></div>";
                            }



                        ?>
                        </div>



                        

                    
    <div class="modal" id="modalAddSubject" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add Subject</h4>
                                     </div>
                                    <div class="modal-body">
                                        <input type = 'hidden' id = 'subjectSeq'>                               
                                        Search by
                                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                               <!--  <button type="button" class="btn btn-default" id = 'btnsubjectid'>SubjectID</button> -->
                                                <button type="button" class="btn btn-default" id = 'btnsubjectname'>SubjectName</button>
                                               <!--  <button type="button" class="btn btn-default">Teacher</button> -->
                                            </div>
                                            </br></br>


                                            <input type="text" id = 'subjectName' data-provide="typeahead" autocomplete = 'off' class="form-control" placeholder="" aria-describedby="sizing-addon3">
                                           <!--  <input type="text" id = 'subjectId' data-provide="typeahead" autocomplete = 'off' class="form-control" placeholder="" aria-describedby="sizing-addon3"> -->
                                       

                                            <div id = 'subjectDetail'>    

                                            <div id ='sec'>
                                            Section
                                            <select class="form-control" id ='section'>
                                            </select> 
                                            </div>
                                              Teacher <input id = 'teacher' class="form-control" type = 'text' name = "subjectName" autocomplete = 'off' disabled> </br>
                                            </br>
                                        </div>
                                            
                                         
                                           
                                            


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id = 'add' class="btn btn-default">Add</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
<script src="js/sidebar_menu.js"></script>	 
</body>
</html>