<?php
    session_start();
    $memberSeq = $_SESSION['memberSeq']; 
    $subject = $_GET['q'];
    $_SESSION['subjectPhoto'] = $subject;
    //echo $memberSeq;

    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "studentassistantDB";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sql = "SELECT member_subject.*,subject.* FROM member_subject INNER JOIN subject ON subject.subject_seq 
            = member_subject.subject_seq where member_seq ='".$memberSeq."'";
    $objQuery = mysqli_query($conn,$sql);

    // if(mysqli_num_rows($objQuery) > 0){
    //         while($row = mysqli_fetch_array($objQuery)){
    //             echo $row['subject_name'];
    //         }


    // }
    // else{

    // }//handle user empty subject
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>upload Photo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css" />
    <script src="js/bootstrap-datepicker.min.js"></script>
     <link href="css/jasny-bootstrap.min.css" rel="stylesheet">
</head>

<script type="text/javascript">
$(document).ready(function() {

    var options = {
            //target:   '#output',
            beforeSubmit:  beforeSubmit,
            uploadProgress: OnProgress, //upload progress callback
            success:       afterSuccess,
            resetForm: true  
        };
       
     $('#MyUploadForm').submit(function() {
            $(this).ajaxSubmit(options);           
            return false;
        });

function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
    //console.log(percentComplete);
    $('input[type="submit"]').prop('disabled', true);
    $('input[type="submit"]').val('Uploading');
    $("select").prop('disabled', true);
    $("input").prop('disabled', true);
    $('#txtPath').hide();
    $('.btn-file').hide();
  
    $('.progress-bar').text(percentComplete+"%");
    $('.progress-bar').css('width',percentComplete+'%');
   
    //$('.progress-bar').text(percentComplete+"%");
}

function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
    {

        if( !$('#imageInput').val()) //check empty input filed
        {
            //$("#output").html("Are you kidding me?");
            return false
        }
        
        var fsize = $('#imageInput')[0].files[0].size; //get file size
        var ftype = $('#imageInput')[0].files[0].type; // get file type
        
        var name = $('#imageInput').val();
        $('#filename').val(name);
        //allow only valid image file types 
        switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                return false;
        }
        
        //Allowed file size is less than 1 MB (1048576)
        // if(fsize>2048576) 
        // {
        //     $("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
        //     return false
        // }
        
        // //Progress bar
        // progressbox.show(); //show progressbar
        // progressbar.width(completed); //initial value 0% of progressbar
        // statustxt.html(completed); //set status text
        // statustxt.css('color','#000'); //initial color of status text

                
        // $('#submit-btn').hide(); //hide submit button
        // $('#loading-img').show(); //hide submit button
        // $("#output").html(""); 
          $('.progress').show(); 
    }
    else
    {
        //Output error to older unsupported browsers that doesn't support HTML5 File API
        $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
        return false;
    }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

function afterSuccess(){
    var name = $('#filename').val();
    
    $(".progress").hide();
    $("#filepath").html("<li class='list-group-item list-group-item-success'><center>"+name+"<b> upload successfully</b>"+"</center></li>");  
    $('#imageInput').show();
    $("#subjectuser").prop('disabled', false);
    $("input").prop('disabled', false);
    $("select").prop('disabled', false);
    $('#txtPath').show();
    $('.btn-file').show();
    $('input[type="submit"]').prop('disabled', false);
    $('input[type="submit"]').val('Upload');
}                
  $('#imageInput').change(function(){
       //$('#submitFile').click();
       var filepath = $('#imageInput').val();
       $('#filepath').html("<center><h6>"+filepath+"</h6></center>");

  });

    // alert('submit automatically');
    // $('#submitFile').click();


//$('#submitFile').hide();
$('.progress').hide();

  $('#datepicker1').datepicker({
        format: "dd M yyyy",
        orientation: "top auto",
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $("select").prop('disabled', false);
    $("input").prop('disabled', false);

    $(document).on('click', ".sharePrivate", function(){
        // var fileSeq = $('td').find('.fileSeq').val();
        // alert(fileSeq);
        var fileSeq = $(this).find('.fileSeq').val();
       
       

        $.ajax({
                method: "POST",
                url: "shareFile.php",
                data: "fileSeq="+fileSeq,
                success: function(msg){
                   
                    $('#shareDetail').html(msg);
                   
                }
        });

    });


        $(document).on('click', ".sharePublic", function(){
        // var fileSeq = $('td').find('.fileSeq').val();
        // alert(fileSeq);
        var fileSeq = $(this).find('.fileSeq').val();
       
       

        $.ajax({
                method: "POST",
                url: "shareFile.php",
                data: "fileSeq="+fileSeq,
                success: function(msg){


                   
                    $('#shareDetail2').html(msg);
                   
                }
        });

    });

     $(document).on('click', "#sharebtn", function(){
        // var fileSeq = $('td').find('.fileSeq').val();
        // alert(fileSeq);
        var that = $(this);
        //alert(that.value);
        var fileSeq = $('#fileSeq').val();
        //alert(fileSeq);
       

        $.ajax({
                method: "POST",
                url: "updatePermissionFile.php",
                data: "fileSeq="+fileSeq,
                success: function(msg){

                     //$('#shareDetail').html(msg);
                   
                    // $('#privateFileList').html("<table class = 'table table-bordered' id = 'privateFileList'><th>Private Files</th>");
                    // $('#privateFileList').append(msg);
                   
                }
        });

    });

        $(document).on('click', "#sharebtn2", function(){
        // var fileSeq = $('td').find('.fileSeq').val();
        // alert(fileSeq);
       
        //alert(that.value);
        var fileSeq = $('#fileSeq').val();
        //alert(fileSeq);
       

        $.ajax({
                method: "POST",
                url: "updatePermissionFile2.php",
                data: "fileSeq="+fileSeq,
                success: function(msg){
                   
                    $('#shareDetail2').html(msg);
                   
                }
        });

    });

});
</script>

<style type="text/css">

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

   

    .iconEdit{
        float:right;
        word-spacing: 0.7em;
    }
     .iconEdit2{
        float:right;
       
    }
/*
    td
    {

        text-align:center; 
        vertical-align:middle;

    }*/


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
                <li>
                    <a href="showContactFriend.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-book fa-stack-1x "></i></span> Contact</a>
                </li>
                <li class="active">
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

                                <?php
                        echo "<center><h3> Photo</h3></center>";
                        ?>
                   
                                <br>
                      <span class = 'iconEdit2'> <button type="button" data-toggle='modal' data-target='#myModal' class="btn btn-default">
  Upload file
</button> </span>
<br><br>

                                
                                
                                <div class="row">
  
  <div class="col-lg-12">
    <div class="input-group">
     
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
           
        <div class = 'row'>
            <div class = 'col-lg-12 col-xs-12'>
               

                    <table class = 'table table-bordered' id = 'privateFileList'>
                  
                              
                    
                    


                     <th>Private Files</th> 

           
                    <?php
                    



                $sql1 = "SELECT * FROM FILE where subject_seq = '".$subject."'and file_permission = 'private' and member_seq = '".$memberSeq."'";
                $objQuery1 = mysqli_query($conn,$sql1);
                
                    echo "<div id = 'list'>";
                    while($row1 = mysqli_fetch_array($objQuery1)){
                        
                        echo "<tr><td colspan = '2'>";
                        //echo "<input type ='hidden' class = 'fileSeq' value = '".$row1['filekey']."'>";
                        echo $row1['file_title'];
                        echo "</br>";
                        echo $row1['file_detail']."</br>";
                        echo "Date Created ".$row1['file_create_at'];
                        echo "<div class ='iconEdit'>";
                      
                        //echo "</br>";
                        echo "<a  href='download.php?file=".$row1['filekey']."'>Download</a> ";
                        echo "<a  href='#' class = 'sharePrivate' data-toggle='modal' data-target='#myModal2'>Share <input type ='hidden' class = 'fileSeq' value = '".$row1['filekey']."'> </a> ";
                       
                        echo "</div>";
                        echo "</td></tr>";
                    }
                    echo "</div>";

        



                    ?>

       
                      </table>


                        <table class = 'table table-bordered'>
                   <!--  <?php echo "<td colspan = '2'>".$subject."</td></tr>"; ?> -->

                              
                    
                    


                     <th colspan = '2'>Public Files</th>

                  

                    <?php


                            //public file
                $sql1 = "SELECT * FROM FILE where subject_seq = '".$subject."'and file_permission = 'public' and member_seq = '".$memberSeq."'";
                $objQuery1 = mysqli_query($conn,$sql1);
                
                    
                    while($row1 = mysqli_fetch_array($objQuery1)){
                        echo "<tr><td colspan = '2'>";
                        //echo "<input type ='hidden' class = 'fileSeq' value = '".$row1['filekey']."'>";
                        echo $row1['file_title'];
                        echo "</br>";
                        echo $row1['file_detail']."</br>";
                        echo "Date Created ".$row1['file_create_at'];
                        echo "<div class ='iconEdit'>";
                      
                        //echo "</br>";
                        echo "<a  href='download.php?file=".$row1['filekey']."'>Download</a> ";
                        echo "<a  href='#' class = 'sharePublic' data-toggle='modal' data-target='#myModal3'>Option <input type ='hidden' class = 'fileSeq' value = '".$row1['filekey']."'> </a> ";
                       
                        echo "</div>";
                        echo "</td></tr>";
                    }
                    




                    ?>
                

                      </table>


           <!-- Modal for Add Semester First Time -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Upload File</h4>
                                     </div>
                                    <div class="modal-body">
                                            <div class="form-group">                               
    <form action="uploadMultipleFile.php" method="POST" enctype="multipart/form-data" id='MyUploadForm'>
                                           <input type = 'hidden' id = 'filename'>

                                       Subject <select class="form-control" name = 'subjectuser'>
                                        <?php
                                         $objQuery = mysqli_query($conn,$sql);
                                            while($row = mysqli_fetch_array($objQuery)){
                                                echo "<option value = '".$row['subject_seq']."'>";
                                                echo  $row['subject_name']."</option>";
                                            }


                                        ?>
                                    </select> <br>      
                                           Title <input type = 'text' class="form-control" name = "title"> </br>
                                           Detail <input type = 'text' class="form-control" name = "detail"> </br>
                                           Date Created <input type = 'text' class="form-control" id = 'datepicker1' name = "datecreated"> </br>

                                         
                                    

    <span id = 'txtPath'>Choose Path File</span>
</br>
    <span class="btn btn-default btn-file">
    Browse    <input type="file" id="imageInput"  name="files[]" multiple="multiple" />
    </span>
    </br></br>
    <ul class="list-group">
    <div id = 'filepath'></div>
    </ul>
    

</div>


    <div id = 'output'></div>

    <div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">
    0%
  </div>
</div>
                                    </div>
                                    
    <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
             <input type="submit" class="btn btn-default"  value ='Upload'  id = 'submitFile'/> 
             </form>                                   
    </div>
                                    
                                </div>
                            </div>


                        </div>


       
            </div>

        </div>

          <!-- Modal for Edit Data Friend-->
                        <div class="modal" id="myModal2" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Share File</h4>
                                     </div>
                                    <div class="modal-body">
                                        <div id ='shareDetail'>

                                        </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                        
                                        <button type="button" id = 'sharebtn' class="btn btn-default">Share</button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal for Edit Data Friend-->
                        <div class="modal" id="myModal3" role="dialog">
                            <div class="modal-dialog">

                                 <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Change File Permission</h4>
                                     </div>
                                    <div class="modal-body">
                                        <div id ='shareDetail2'>

                                        </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                        
                                        <button type="button" id = 'sharebtn2' class="btn btn-default"> Change to Private</button>
                                        
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
