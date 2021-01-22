 @extends('superadmin_layout')
   @section('content')
   @section ('extra_css')
    <style>
    	@media only screen and (max-width: 600px) {
      #sueradminChart{
        width:295px;
    }
    	}
    ul.burst li::after {  content: "";  position: absolute;  top: 4px;    left: -18px;  height: 10px;  width: 10px;  background: #ff6600;  -webkit-transform: rotate(45deg);  -moz-transform: rotate(45deg);  -ms-transform: rotate(45deg);  -o-transform: rotate(45deg);  transform: rotate(45deg);}
        .superadmin_circular_add ul li
        {
            font-size: 14px;
            margin-left: 25px;
            padding: 0px;
            list-style: none;
            line-height: 15px;
	    position:relative;
        }
        .superadmin_circular_add ul li:hover
        {
            box-shadow: 0px 0px 12px #9e9ea3;
        }
        .superadmin_circular_add ul li a{
            font-size: 12px;
            text-decoration: underline;
            color: #4691d7;
            display: inline-block;
            cursor:pointer;
        }
.superadmin_circular_add ul li:before{
content:url("https://projectdemoonline.com/grcgreentest/public/assets/images/arrow.png");
position:absolute;
left:-24px;
top:5px;
}
    </style>
@stop
  @if(session('role') =='superadmin')


    <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
 @if(empty(session('type')))

                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style m-b-20 p-10 new_breadcrumb_design">
                            <div class="col-sm-6">
                                <h4 class="page-title">Super Admin Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    @endif
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-8 col-xl-8">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">

                                    @if(empty(session('type')))
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Users-list')}}">
                                                                <img src="assets/images/user_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/user_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$usercount??0}} Users</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Organization-list')}}">
                                                                <img src="assets/images/organization.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/organization.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$orgnagationcount??0}} Organizations</h4>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Project-list')}}">
                                                                <img src="assets/images/projects_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/projects_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$projectcount??0}} Projects</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  @endif


                                </div>
                            </div>
                            <div class="card crd-blue-border card_box_shadow">
                                <div class="card-body no_box_shadow">
                                    <!-- <div class="dashboard_for_wrapper">    
                                        <ul>
                                            <li><a href="#">User</a></li>
                                            <li><a href="#">Organization</a></li>
                                            <li><a href="#">Project</a></li>
                                        </ul>
                                    </div> -->
                                    <div class="chart_responsive">
                                        <div class="chart_responsive_inner">    
                                            <canvas id="sueradminChart" height="130"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4 col-xl-4">
                            <div class="card crd-blue-border card_box_shadow update_border_radius super_admin_dashboard">
                                <div class="card-body no_box_shadow">
                                    <a href="#">Circular</a>
                                    <div class="superadmin_circular_add vscroll">
                                        <ul class="dashboard_responsive burst">
                                        @foreach($circular as $circulars)
                                            <li class="more"> {{$circulars->circular_name}}
                                            @if(!empty($circulars->attachment))
                                          
                                          <a href="{{URL::to('/attachement')}}/{{$circulars->attachment}}" target="_blank"  > {{$circulars->attachment}}</a>
                                        
                                         @endif
                                            
                                            </li>
                                         

                                            @endforeach
                                          
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- content -->
            <!-- <footer class="footer">© 2019 GRC</footer> -->
        </div>


  @elseif(session('role') =='admin')

   <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
               @if(empty(session('type')))

                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style m-b-20 p-10 new_breadcrumb_design">
                            <div class="col-sm-6">
                                <h4 class="page-title">Admin Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    @endif
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-8 col-xl-8">
                            <div class="card crd-blue-border card_box_shadow">
                                <div class="card-body no_box_shadow">
                                    <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">

                                     @if(empty(session('type')))
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Users-list')}}">
                                                                <img src="assets/images/user_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/user_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$usercount??0}} Users</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('/Organization-view/'.session('org_id'))}}">
                                                                <img src="assets/images/organization.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/organization.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$orgnagationcount??0}} Organizations</h4>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Project-list')}}">
                                                                <img src="assets/images/projects_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/projects_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$projectcount??0}} Projects</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                </div>
                            </div>
                                    <div class="chart_responsive">
                                        <div class="chart_responsive_inner">    

                                            <canvas id="adminChart" height="150"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="col-xs-12 col-sm-12 col-md-4 col-xl-4">
                            <div class="card crd-blue-border card_box_shadow update_border_radius super_admin_dashboard">
                                <div class="card-body no_box_shadow">
                                    <a href="add-circular.html">Circular</a>
                                    <div class="superadmin_circular_add">
                                        <ul class="dashboard_responsive burst">
                                        @foreach($circular as $circulars)
                                            <li> {{$circulars->circular_name}}
                                            @if(!empty($circulars->attachment))
                                          
                                          <a href="{{URL::to('/attachement')}}/{{$circulars->attachment}}" target="_blank"  > {{$circulars->attachment}}</a>
                                        
                                         @endif
                                            
                                            </li>
                                         

                                            @endforeach
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- content -->
            <!-- <footer class="footer">© 2019 GRC</footer> -->
        </div>


@elseif(session('role') =='project_Manager')

        <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                     @if(empty(session('type')))
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style m-b-20 p-10 new_breadcrumb_design">
                            <div class="col-sm-6">
                                <h4 class="page-title">Project Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-8 col-xl-8">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">
                                   
 @if(empty(session('type')))
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Users-list')}}">
                                                                <img src="assets/images/user_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/user_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$usercount??0}} Users</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('Organization-view')}}/">
                                                                <img src="assets/images/organization.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/organization.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$orgnagationcount??0}} Organizations</h4>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-xl-4">
                                            <div class="mini-stat text-white dashboard_for_wrapper">
                                                <div class="card-body dashboard_cls">
                                                    <div>
                                                        <h5 class="font-16 text-uppercase m-0 text-center">
                                                            <a href="{{URL::to('/Project-list')}}">
                                                                <img src="assets/images/projects_img.png" class="first_theme">
                                                                <img src="assets/images/secondary-theme/projects_img.png" class="second_theme">
                                                            </a>
                                                        </h5>
                                                        <h4 class="font-500 text-center font-dark font-20 m-0">{{$projectcount??0}} Projects</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                         @endif

                                </div>
                            </div>
                            <div class="card crd-blue-border card_box_shadow">
                                <div class="card-body no_box_shadow">
                                    <div class="chart_responsive">
                                        <div class="chart_responsive_inner">    
                                            <canvas id="adminChart" height="130"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4 col-xl-4">
                            <div class="card crd-blue-border card_box_shadow update_border_radius super_admin_dashboard">
                                @php(

                              $empdeatails = DB::table('grc_user')->where('role','employee')->where('status',1)->get()
                                )
                                <div class="card-body no_box_shadow">
                                    <div class="project_condition_wrapper">
                                        <span>Select User</span>
                                        <select class="form-control" id="usesdata" onchange="getdetails(this.value )">
                                            <option value="">Select Option </option>

                                            @foreach($empdeatails as $k => $empdeatailss)
                                               <?php

                                               if($k == 0){

                                                $select = 'selected';

                                               }else{

                                                 $select = '';

                                               }

                                               ?>
                                            <option {{$select}} value="{{$empdeatailss->id}}">{{ $empdeatailss->first_name}}  {{ $empdeatailss->middle_name}}  {{ $empdeatailss->user_name}}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                    <div class="task_condition_list">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped details">
                                                <tr>
                                                    <th>Task</th>
                                                    <th>Condition</th>
                                                    <th>Probability</th>
                                                </tr>
                                               
                                                   
                                                
                                             
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- content -->
            <!-- <footer class="footer">© 2019 GRC</footer> -->
        </div>


  @else

  <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style m-b-20 p-10 new_breadcrumb_design">
                            <div class="col-sm-6">
                                <h4 class="page-title">User Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-12 col-xl-12">
                            <div class="card crd-blue-border card_box_shadow">
                                <div class="card-body no_box_shadow">
                                    <div class="user_dashboard_wrapper">
                                        <h2>Lorem Ipsum solor dimit</h2>
                                        <div class="user_task_list_wrapper">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th>Task</th>
                                                        <th>Condition</th>
                                                        <th>Probability</th>
                                                    </tr>
                                                   
                                                    @foreach($usertask as $usertasks)
                                                    <tr>
                                                        <td>{{$usertasks->task_name}}</td>
                                                        <td>{{$usertasks->category}}</td>
                                                        <td>{{$usertasks->Probability}}</td>
                                                    </tr>
                                                    @endforeach
                                                  
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- content -->
            <!-- <footer class="footer">© 2019 GRC</footer> -->
        </div>

  @endif
       
            @stop

            @section('extra_js')

            <script type="text/javascript">
                
              var userid = $('#usesdata').val();

              getdetails(userid);

              

            function getdetails(userid){

               


              var _token = "{{csrf_token()}}";

                 var html = '';

   
         $.ajax({
   
             url: siteurl+'/public/getdeails',
   
             type: "POST",
   
             data: {"_token": _token,"userid":userid},
             dataType: 'JSON',
   
             success: function (response) {
                 console.log(response);

                  html +=' <tr><td>Task</td><td>Condition</td>  <td>Probability</td></tr>';
   
                 if (response.length > 0) {
                     $.each(response, function (k, v)
                     {
                         html +=' <tr><td>'+v.task_name+'</td><td>'+v.category+'</td>  <td>'+v.Probability+'</td></tr>';
                                           
   
                     });
                 }else{ 
                     html += '<tr><td conspan="3">Recoud Not Found</td></tr>';
                 }
                  $("table.details").html(html);
             }
        });
         }
$(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 300;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.more').each(function() {
        var content = $(this).html();
           
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
           console.log(c);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        debugger
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
            </script>


            @stop