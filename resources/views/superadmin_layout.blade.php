<?php 
use App\Http\Controllers\CommonController;

    $setting = CommonController::login_user_details();
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title>GRC GREEN</title>
    <meta content="GRC GREEN" name="description">
    <meta content="kloudrac" name="author">
    <link rel="shortcut icon" href="{{URL::to('assets/images/logo.png')}}">
    <!--Chartist Chart CSS -->
    <link rel="stylesheet" href="{{URL::to('assets/css/chartist.min.cs')}}">
    <link href="{{URL::to('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/metismenu.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/style.css')}}" id="cpswitch" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/jquery.colorpanel.css')}}" rel="stylesheet" type="text/css">

    <link href="{{URL::to('assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('assets/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    
    <!-- Responsive datatable examples -->
    <link href="{{URL::to('assets/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <!--<link href="{{URL::to('assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />-->
    <link href="{{URL::to('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>




     <style type="text/css">
	@media only screen and (max-width: 600px) {
      #sueradminChart{
        width:295px !important;
    }
    	}
      label.error { 
   float: none; color: red; 
   padding-left: .5em;
   vertical-align: top; 
   display: block;
}

/*form, p {
  margin: 20px;
}

p.note {
  font-size: 1rem;
  color: red;
}

input, textarea {
  border-radius: 5px;
  border: 1px solid #ccc;
  padding: 4px;
  font-family: 'Lato';
  width: 300px;
  margin-top: 10px;
}

label {
  width: 300px;
  font-weight: bold;
  display: inline-block;
  margin-top: 20px;
}

label span {
  font-size: 1rem;
}

label.error {
    color: red;
    font-size: 1rem;
    display: block;
    margin-top: 5px;
}

input.error, textarea.error {
    border: 1px dashed red;
    font-weight: 300;
    color: red;
}

[type="submit"], [type="reset"], button, html [type="button"] {
    margin-left: 0;
    border-radius: 0;
    background: black;
    color: white;
    border: none;
    font-weight: 300;
    padding: 10px 0;
    line-height: 1;
}*/
      
   #loadingDiv{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#0d0d0d;
  background-image:url("{{URL::asset('uploads/ajax-loader.gif')}}");
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.8;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
   </style>

    @yield('extra_css') 
</head>

<body>
    <div id="wrapper">
      <div id="loadingDiv" style="display: none;"></div>
@include('common.superadmin_header')
   @include('common.superadmin_leftsidebar')
  @yield('content') 
  
  <?php
  $orname = array();
  $orstatus = array();
  $bgcolor = array();
  $orgnagation = DB::table('grc_organization')->where('status',1)->get();
  
  
  foreach($orgnagation as $k=>$orgnagations){
                
$projects = DB::table('grc_project')

  ->join('alm_states','grc_project.state','=','alm_states.id')
        ->join('alm_cities','grc_project.city','=','alm_cities.id')
        ->join('main_currency','grc_project.currency_id','=','main_currency.id')
        ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
        ->join('grc_sector','grc_project.sector','=','grc_sector.id')
        ->join('grc_user','grc_project.project_manager','=','grc_user.id')


        ->where('grc_project.organization_id',$orgnagations->id)->where('grc_project.status',1)->count();
    $orname[] = $orgnagations->org_name;
    $orstatus[] = $projects;
    if($k % 2 ==0){
     $color =  'rgb(87, 148, 238)';
    }else{

      $color = 'rgb(82, 224, 122)';

    }
    $bgcolor[] =  $color;
  }
  
  $enorname = json_encode($orname);
 $enstatus = json_encode($orstatus);   
 $encolor = json_encode($bgcolor);

 
  ?>

  <?php
 $projectName = array();
 $projectColor= array();
  $projectstaus= array();
$project = DB::table('grc_project');
if(session('role') != 'superadmin'){
$project->where('organization_id',session('org_id'));    
}

 $project = $project->where('status',1)->get();
 foreach($project as $k=>$projectsdate){
  $condition = DB::table('grc_project_condition_doc')->where('project_id',$projectsdate->id)->where('status',1)->count();
    $projectName[] = $projectsdate->project_name;
     if($k % 2 ==0){
     $color =  'rgb(87, 148, 238)';
    }else{

      $color = 'rgb(82, 224, 122)';

    }
    $projectColor[] = $color;
    $projectstaus[] = $condition;

    }

 $enProjectname = json_encode($projectName);
 $enProjectstatus = json_encode($projectstaus);   
 $enPojectcolor = json_encode($projectColor);

  ?>
   
      </div>
      <!-- ============================================================== -->
      <!-- End Right content here -->
      <!-- ============================================================== -->
     <!-- jQuery  -->
    <script src="{{URL::to('assets/js/jquery.min.js')}}"></script>
    <script src="{{URL::to('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('assets/js/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{URL::to('assets/js/waves.min.js')}}"></script>
    <!--Chartist Chart-->
    <script src="{{URL::to('assets/js/chartist.min.js')}}"></script>
    <script src="{{URL::to('assets/js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{URL::to('assets/js/chart.min.js')}}"></script>
    <script src="{{URL::to('assets/js/chartjs.init.js')}}"></script>
    <!-- peity JS -->
    <script src="{{URL::to('assets/js/jquery.peity.min.js')}}"></script>
    <script src="{{URL::to('assets/js/dashboard.js')}}"></script>
    <!-- App js -->
    <script src="{{URL::to('assets/js/app.js')}}"></script>
    <script src="{{URL::to('assets/js/excanvas.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.knob.js')}}"></script>
    <script src="{{URL::to('assets/js/jquery.colorpanel.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{URL::to('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{URL::to('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::to('assets/js/buttons.bootstrap4.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{URL::to('assets/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('assets/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Datatable init js -->
   <!--  <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script> -->
    <script src="{{URL::to('assets/js/datatables.init.js')}}"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
     <script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>  -->
    <script src="http://malsup.github.com/jquery.form.js"></script> 
       <!--<script src="{{URL::to('assets/js/bootstrap-datepicker.js')}}"></script>-->
       <!--<script src="{{URL::to('assets/js/bootstrap-datepicker.min.js')}}"></script>-->
  <script src="{{URL::to('assets/js/select2.min.js')}}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>


    <script>var siteurl = window.location.origin+'/grcgreentest';</script>
    
   
    @yield('extra_js') 
    
     <script>


        function view_noti(view_ids){

            console.log(view_ids);


         $.ajax({
   
             url:siteurl+'/public/view-noti/'+view_ids,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 
                 $('.show_noti').text(response.count_noti);
            
             }
        })  
        }

   @if(!empty(session('type')))
    $('.content-page').addClass('m-0');
    $('.content.p-0').addClass('m-0');
    @endif

      function uploadprofile(){

   formData  =  new FormData();
  var files = $('#attfileimg')[0].files[0];


formData.append('attfile', files);

   error =1;

      if(error ==1){

      var token = "{{csrf_token()}}"; 

      $.ajax({
      url: siteurl+'/public/attach-file',
      headers: {'X-CSRF-TOKEN': token},                          
      type: "POST",
      cache: false,
      dataType:'json',
      processData: false,
      contentType: false,
      data:formData,
      success:function(data){
        console.log(data);
        if(data.status ==200){
         $('#filename').val(data.Attfile);   
        }
       },
    });

      }


 }










            function validatePassword(password) {
                
                // Do not show anything when the length of password is zero.
                if (password.length === 0) {
                    document.getElementById("msg").innerHTML = "";
                    return;
                }
                // Create an array and push all possible values that you want in password
                var matchedCase = new Array();
                matchedCase.push("[$@$!%*#?&]"); // Special Charector
                matchedCase.push("[A-Z]");      // Uppercase Alpabates
                matchedCase.push("[0-9]");      // Numbers
                matchedCase.push("[a-z]");     // Lowercase Alphabates

                // Check the conditions
                var ctr = 0;
                for (var i = 0; i < matchedCase.length; i++) {
                    if (new RegExp(matchedCase[i]).test(password)) {
                        ctr++;
                    }
                }
                // Display it
                var color = "";
                var strength = "";
                switch (ctr) {
                    case 0:
                    case 1:
                    case 2:
                        strength = "Very Weak";
                        color = "red";
                        break;
                    case 3:
                        strength = "Medium";
                        color = "orange";
                        break;
                    case 4:
                        strength = "Strong";
                        color = "green";
                        break;
                }
                document.getElementById("msg").innerHTML = strength;
                document.getElementById("msg").style.color = color;
            }
        </script>

    
    
    <script>
        $(".checkbox-dropdown").click(function () {
    $(this).toggleClass("is-active");
});


setTimeout(function(){
  $('.alert').remove();
}, 5000);

$(".checkbox-dropdown ul").click(function(e) {
    e.stopPropagation();
});

$('form').on('blur', 'input[type="text"], textarea', function() {
    // ES6
    // $(this).val((i, value) => value.trim());

    // ES5
    $(this).val(function(i, value) {
         return value.trim();
    });
});



</script>
<script>
   CKEDITOR.replace( 'figuresite' );
</script>
<script>
   CKEDITOR.replace( 'actualsite' );
</script>
 <!-- <script>
        $(function () {
            $(".knob").knob();
        });
    </script>-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        var ctx = document.getElementById('sueradminChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: {!!$enorname!!},
                datasets: [{
                    label: 'Project',
                    barThickness: 3,
                    //responsive: true,
                    data: {!!$enstatus!!},
                    backgroundColor: {!!$encolor!!},
                    borderColor:{!!$encolor!!},
                    borderWidth: 10
                }]
            },
            options: {
                responsive:true,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                           // steps: 100,
                            stepSize: 100,
                            //stepValue: 10,
                            //max: 500 //max value for the chart is 60
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Organization',
                            fontSize: 12,
                            fontColor: "#000000",
                            fontStyle: "bold"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'No. of Running Project',
                            fontSize: 16,
                            fontColor: "#000000",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });

        $('.dashboard_responsive').slick({
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            vertical: true,
            verticalSwiping: true,
        });




    </script>


     <script>
        var ctx = document.getElementById('adminChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!!$enProjectname!!},
                datasets: [{
                    label: 'Department',
                    barThickness: 3,
                    responsive: true,
                    horizontalBars: true,
                    data: {!!$enProjectstatus!!},
                    backgroundColor: {!!$enPojectcolor!!},
                    borderColor: {!!$enPojectcolor!!},
                    borderWidth: 5
                }]
            },
            options: {
                responsive:true,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            //steps: 40,
                            stepSize: 100,
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Condition',
                            fontSize: 16,
                            fontColor: "#000000",
                            fontStyle: "bold"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Projects',
                            fontSize: 16,
                            fontColor: "#000000",
                            fontStyle: "bold"
                        }
                    }]
                }
            }
        });

        $('.dashboard_responsive').slick({
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: false,
            autoplay: true,
            vertical: true,
            verticalSwiping: true,
        });

    </script>

 
   <script>




  $( "#organizationname" ).change(function() {
   
     var cid =  $("#organizationname").val();
   
    
   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/mng_list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 console.log(response);
                    html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{ 
                     html += 'state not available';
                 }
                  $("#projectmanager").html(html);
             }
        })
   });
   
    






    
   $( "#orgcountry" ).change(function() {
   
     var cid =  $("#orgcountry").val();
   
   
   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/state-list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 console.log(response);
                    html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{ 
                     html += 'state not available';
                 }
                  $(".statelist").html(html);
             }
        })
   });
   
</script>  
<script>
   $( "#orgstate" ).change(function() {
   
     var cid =  $("#orgstate").val();
   
     
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/city-list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 //console.log(response);
                html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
   
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{  
                     html += 'city not available';
                 }
                  $(".citylist").html(html);
             }
        })  
   });
   
</script>
<script>
 $(document).on('change','#projectstate',function(){
     
     var  cid = $('#projectstate').val();
   

   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/city-list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
   
   
   
                 //console.log(response);
   
                 if (response.length > 0) {
   
                   
   
                     $.each(response, function (k, v)
   
                     {
   
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
   
                   
   
                 }else{                  
   
                     html += 'city not available';
   
                 }
   
   
   
                  $(".citylist").html(html);
   
   
   
             }
   
        })             
   
   });
   
</script>
 <script>
   $( "#empcountry" ).change(function() {
   
     var cid =  $("#empcountry").val();
   
     // alert(cid);
   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/state-list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 console.log(response);
                 html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{ 
                     html += 'state not available';
                 }
                  $(".statelist").html(html);
             }
        })
   });
   
</script>  
<script>
   $( "#empstate" ).change(function() {
   
     var cid =  $("#empstate").val();
   
     // alert(cid);
   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/city-list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 //console.log(response);
                 html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
   
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{  
                     html += 'city not available';
                 }
                  $(".citylist").html(html);
             }
        })  
   });
   
</script>    
<script>
    function checkPasswordMatch() {
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
});
</script>
<script>
//         function getInputValue(){
           
//           debugger
           
//             // Selecting the input element and get its value 
//             var orgname = document.getElementById("orgname").value;
            
           
            
//             var orgemail = document.getElementById("org_email").value;


//           // var uname = document.getElementById("adminname").value;
//             var orgmobile = document.getElementById("org_mobile").value;
//             var orgalterno = document.getElementById("orgalterno").value;
//             var orgcountry = $("#orgcountry option:selected").text();
//             var orgstate = $("#orgstate option:selected").text();
//             var orgcity = $("#orgcity option:selected").text();
//             var orgpincode = document.getElementById("orgpincode").value;
            

            
           
//             $("#previeworgname").html(orgname);
//             $("#previeworgemail").html(orgemail);
//             // $("#previeworguname").html(uname);
//             $("#previeworgmobile").html(orgmobile);
//             $("#previeworgaltno").html(orgalterno);
//             $("#previeworgcountry").html(orgcountry);
//             $("#previeworgstate").html(orgstate);
//             $("#previeworgcity").html(orgcity);
//             $("#previeworgpincode").html(orgpincode);
           
//         }
//     </script>

    <script>
        
    </script>

    
 <script type="text/javascript">
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile_image").change(function(){
        readURL(this);
    });
</script>
<script>
    $(document).ready(function(){
        $(".advance_setting").on("click", function(){
            $(".state_dist_wrapper").addClass("state_dis_cls");
        });
        $(".close_popup").on("click", function(){
           $(".state_dist_wrapper").removeClass("state_dis_cls"); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            // alert('The file "' + fileName +  '" has been selected.');
            $(".browse_file").val(fileName);
        });
    });
</script>
<script>
    $(document).ready(function(){
        $(".hint_details a").on("click", function(){
            $(".hint_details_body").toggleClass("show_hint");
        });
    });
</script>
<script>

   $( "#sectorI" ).change(function() {
   
     var sectorid =  $("#sectorI").val();
     var stateid =  $("#statesI").val();
   
     // alert(cid);
     if($('#statesI').val() == 0){
        alert('Select state first!');
     }else if($('#statesI').val() == ''){
         alert('Select state first!');
       // alert(cid)
     }else{

           var html = '';
           var html1 = '';
           var html2 = '';
           var html3 = '';
     var _token = "{{csrf_token()}}";
         $.ajax({
              
             url:siteurl+'/public/Document',
   
             type: "Post",
              data: {_token: _token,stateid: stateid,sectorid:sectorid},
            
             cache: false,
   
             dataType: 'json',

   
             success: function (response) {
                 //console.log(response.data.docData4);
   
                /* if (response.length > 0) {*/
                    
                    // $('#collapseOne').addClass('show');
                    //  $('#collapseOne').addClass('show');
                    //     $('#collapseTwo').addClass('show');
                    //        $('#collapseThree').addClass('show');
                    //           $('#collapseFour').addClass('show');

                  if(response.data.docData1.length == 0 ){

                     html += '<label for="checkbox_1">'+'<span class="m-r-10">No Data Found</span>'+'</label>';

                  }
                     var i =1;
                     $.each(response.data.docData1, function (k, v)
                     {
                        html += '<label for="checkbox_1">'+'<span class="m-r-10">'+i+ '.'+'</span>'+v.document+'</label>';
                         /*html +=' <option class="p-option" value="'+v.id+'">''</option> ';*/
                        i++;
                     });
                      $(".ec").html(html);

                      if(response.data.docData2.length == 0 ){

                     html1 += '<label for="checkbox_1">'+'<span class="m-r-10">No Data Found</span>'+'</label>';

                  }
                            var j =1;
                       $.each(response.data.docData2, function (k, v1)
                     {
                        html1 += '<label for="checkbox_1">'+'<span class="m-r-10">'+j+ '.'+'</span>'+v1.document+'</label>';
                         /*html +=' <option class="p-option" value="'+v.id+'">''</option> ';*/
                        j++;
                     });
                      $(".cto").html(html1);

                      if(response.data.docData3.length == 0 ){

                     html2 += '<label for="checkbox_1">'+'<span class="m-r-10">No Data Found</span>'+'</label>';

                  }
                     var z =1;
                       $.each(response.data.docData3, function (k, v2)
                     {
                        html2 += '<label for="checkbox_1">'+'<span class="m-r-10">'+z+ '.'+'</span>'+v2.document+'</label>';
                         /*html +=' <option class="p-option" value="'+v.id+'">''</option> ';*/
                         z++;
                        
                     });
                      $(".cte").html(html2);

                       if(response.data.docData4.length == 0 ){

                     html3 += '<label for="checkbox_1">'+'<span class="m-r-10">No Data Found</span>'+'</label>';

                  }  

                      var l = 1;
                       $.each(response.data.docData4, function (k, v3)
                     {
                        html3 += '<label for="checkbox_1">'+'<span class="m-r-10">'+l+ '.'+'</span>'+v3.document+'</label>';
                         /*html +=' <option class="p-option" value="'+v.id+'">''</option> ';*/
                         l++;
                        
                     });
                      $(".gb").html(html3);
                /* }else{ 
                     html += 'state not available';
                 }*/
                  
             }
        })
     }
   
  
   });
   
</script> 
<script>
    $('input.styled-checkboxami').on('change', function() {
    $('input.styled-checkboxami').not(this).prop('checked', false);  
});
</script>
<script>
$('.styled-checkboxami').on('change', function() {
    $('.docid').val(this.checked ? this.value : '');

});        
</script>
  <script>
      $(".editclass").click(function () {
    
       var userType = $(".styled-checkboxami:checked").attr('data-s');
       $(".show").val(userType);
     
   
  </script>
 
 


<script type="text/javascript">
    $(function () {
        $(".showss").click(function () {

            var selected = new Array();
 
            //Reference the CheckBoxes and insert the checked CheckBox value in Array.
            $(".getval:checked").each(function () {
                selected.push(this.value);
            });
 
         
            //Display the selected CheckBox values.
            if (selected.length > 0) {
               // alert("Selected values: " + selected.join(","));

                var isDelete = confirm("Do you really want to delete records?");
                var _token = "{{csrf_token()}}";
        if (isDelete == true) {
           // AJAX Request
           $.ajax({
              url: siteurl+'/public/delete-condition',
              type: 'POST',
              data: {_token: _token,selected: selected},
              success: function(response){
                console.log(response);
                /* $.each(selected, function( i,l ){
                     $(".custom_checkbox_"+l).remove();
                 });*/
                 window.location.reload();
              }
           });
        }
            }
        });
    });

</script>
<script>
         $(document).ready(function(){
             $(".hint_details a").on("click", function(){
                 $(".hint_details_body").toggleClass("show_hint");
             });
         });
      </script>
 <script>
    $(document).ready(function(){
        $(".edit_icon").on("click", function(){
            $(this).parents("td").find(".saved_details").css("display" , "none");
            $(this).parents("td").find(".user_save_wrapper").css("display" , "inline-block");
        });
        $(".save_user").on("click", function(){
            $(this).parents("td").find("p.saved_details").text($(this).parents(".user_save_wrapper").find(".select_user_inside").val());
            $(this).parents("td").find(".saved_details").css("display" , "inline-block");
            $(this).parents("td").find(".user_save_wrapper").css("display" , "none");
        });
    });
</script>
<script>
    $(document).ready(function(){
        $(".edit_icon").on("click", function(){
            $(this).parents("td").find(".saved_details").css("display" , "none");
            $(this).parents("td").find(".user_save_wrapper").css("display" , "inline-block");
        });
        $(".save_user").on("click", function(){
            $(this).parents("td").find("p.saved_details").text($(this).parents(".user_save_wrapper").find(".select_user_inside").val());
            $(this).parents("td").find(".saved_details").css("display" , "inline-block");
            $(this).parents("td").find(".user_save_wrapper").css("display" , "none");
        });
    });
</script>  


   <script>function preventNonNumericalInput(e) {
  e = e || window.event;
  var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
  var charStr = String.fromCharCode(charCode);

  if (!charStr.match(/^[0-9]+$/))
    e.preventDefault();
}</script>
 
 

</body>

</html>