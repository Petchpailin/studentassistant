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
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css" />
    <script src="js/bootstrap3-typeahead.js"></script> 
    <script src="js/bootstrap-datepicker.min.js"></script>

</head>

<script type="text/javascript">
    $(document).ready(function() {
  
      // keep oldstate
    
      $('#submit').click(function(){
        var arr = $("input[class='multitype']:checked").map(function() {
            return this.value;
        }).get();
        console.log(arr.length);

        var radiobtn = $("input[name='searchtype']:checked").val();
        console.log(radiobtn);
        
      });

      $(document).on('click', "input[name='searchtype']", function(){
        var type = this.value;
    
        var date = "<div id = 'searchdate'><div class='input-daterange input-group' id='datepicker'>"+
        "<input type='text' class='form-control' name='start' />"+
        "<span class='input-group-addon'>to</span>"+
        "<input type='text' class='form-control' name='end' />"+
        "</div> </div>";
        
        if(type === 'subject'){
            console.log('subject');
            $('#searchdate').hide();
            $('#searchinput').show();
            $('#searchdate1').show();

          }
          else if (type === 'date'){
            $('#searchdate1').hide();
            $('#searchinput').hide();
            $('#searchgroup').prepend(date);
            $('#searchdate .input-daterange').datepicker({
              format: "dd/mm/yyyy",
              autoclose: true,
              todayHighlight: true
            });
 

          }
          else{
            $('#searchdate').hide();
            $('#searchinput').show();
            $('#searchdate1').show();

          }
          
      });

   
    $('#searchinput').typeahead({
          source:function(data,process){ //call server to send data
          
                $.get('searchSubject.php?q='+$('#searchinput').val(),function(data){
                    //var subjectCode = $('#subjectName').val();
                    console.log(data);
                    var data_json = JSON.parse(data);
                    process(data_json); //callback fx to parseJSON                
                });

                

            },
            autoSelect: true,
            minLength: 1,
            displayText: function(item){
              return item.subjectName;
            }
    });
  


    $("input[name=searchtype][value='subject']").prop("checked",true);
 

    $('#searchdate .input-daterange').datepicker({
        format: "dd/mm/yyyy",
       
        autoclose: true,
        todayHighlight: true
    });


     $('#searchdate1 .input-daterange').datepicker({
        format: "dd/mm/yyyy",
       
        autoclose: true,
        todayHighlight: true
    });
 



   
      
  
});
</script>

<style type="text/css">

   

    .iconEdit{
        float:right;
    }

     td
    {

        text-align:center; 
        vertical-align:middle;

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
                <li>
                    <a href="showContactFriend.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-book fa-stack-1x "></i></span> Contact</a>
                </li>
                <li>
                    <a href="uploadPhotoAll.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-file fa-stack-1x "></i></span> Multimedia</a>
                </li>
                <li  class="active">
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
                                <center><h3> Search </h3></center>
                                
                                
                                <div class="row">
  
  <div class="col-lg-12">
  </br>
    <div class="input-group" id ='searchgroup'>
      <input type="text" id ='searchinput' class="form-control" data-provide="typeahead" autocomplete = 'off' aria-label="...">
           
      <span class="input-group-btn">
        <button class="btn btn-default" id ='submitsearch' type="button">Go!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
           
        <div class = 'row'>
            <div class = 'col-lg-12 col-xs-12'>
                 <div class="panel panel-default">
            <div class="panel-body">  
   
            
            Type :                                 
           <input class = 'multitype' type="checkbox" value ='lecture' aria-label="..."> Lecture 
           <input class = 'multitype' type="checkbox" value = 'voice' aria-label="..."> Voice
           <input class = 'multitype' type="checkbox" value = 'video' aria-label="..."> Video
           <input class = 'multitype' type="checkbox" value = 'photo' aria-label="..."> Photo
           <br> 

      <!--      <input type = 'button' id = 'submit' value = 'button test'/></br> -->
          </br>
           Search by:</br>
            <label class="radio-inline"><input type="radio" name="searchtype" value ='subject'>Subject</label>
            <label class="radio-inline"><input type="radio" name="searchtype" value = 'date'>Date</label>
            <label class="radio-inline"><input type="radio" name="searchtype" value = 'keyword'>Keyword</label> 
          </br></br>
          <div id = 'searchdate1'>
            Date Range:
            
             <div class="input-daterange input-group" id="datepicker">
            <input class="input-sm form-control" name="start" type="text">
            <span class="input-group-addon">to</span>
            <input class="input-sm form-control" name="end" type="text">
            </div>
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
