@extends('superadmin_layout')@section('content')<div class="content-page">
   <!-- Start content -->
   <div class="content p-0">
      <div class="container-fluid">
         <div class="page-title-box">
            <div class="row align-items-center bredcrum-style">
               <div class="col-sm-6 col-6">
                  <h4 class="page-title text-left">Projects</h4>
               </div>
                <div class="col-sm-6 col-6 text-right">

                                 <form mathod="GET">
                                    <input type="hidden" name="export" value="export">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-download m-r-5"></i>Export</button>
                                </form>

                            </div>
            </div>
         </div> @if(session::has('msg')) <div class="alert alert-success"> {{session::get('msg')}} </div> @endif
         @if(session::has('status')) <div class="alert alert-{{session::get('alert')}} alert-dismissible fade show"
            role="alert">{{session::get('status')}}<button type="button" class="close" data-dismiss="alert"
               aria-label="Close"> <span aria-hidden="true">&times;</span></button></div> @endif
         <!-- end row -->
         <!-- end row -->
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">

  <!--                   <form method="GET" id="date_range">-->
        
  <!--  <div class="dateControlBlock col-sm-12 text-center m-b-10">-->
  <!--      TO <input type="date" name="dateStart" @if(!empty($_GET['dateStart'])) value="{{$_GET['dateStart']}}"  @endif id="dateStart" class="datepicker" style="border:1px solid #333"  size="8" /> From-->
  <!--      <input type="date" name="dateEnd" @if(!empty($_GET['dateEnd'])) value="{{$_GET['dateEnd']}}"  @endif id="dateEnd" class="datepicker" style="border:1px solid #333"  size="8"/>-->
  <!--  </div>-->
  <!--</form>-->
  <div class="col-sm-12 p-0 m-b-10">
       <div class="state_dist">
                                    <div class="advance_setting">
                                        <p><img src="assets/images/left_arrow.png"> Date Search</p>
                                    </div>
                                    <form method="GET" id="date_range">
                                        <div class="state_dist_wrapper">
                                            <div class="close_popup">
                                                <img src="assets/images/close_icon.png" alt="" title="">
                                            </div>
                                            <div class="col-sm-12 text-center m-b-10">
                                                <div class="col-xs-12 col-sm-12 p-0">
                                                    <div class="form-group">
                                                        <label class="d-block text-left">To</label>
                                                        <input type="date" name="dateStart" @if(!empty($_GET['dateStart'])) value="{{$_GET['dateStart']}}"  @endif id="dateStart" class="datepicker state_drop" style="border:1px solid #333;width:100%"  size="8" /> 
                                                        <!--<input type="text" name="projectid" id="projectid" class="state_drop"  placeholder="Project Id">-->
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 p-0">
                                                    <div class="form-group">
                                                        <label class="d-block text-left">From</label>
                                                        <input type="date" name="dateEnd" @if(!empty($_GET['dateEnd'])) value="{{$_GET['dateEnd']}}"  @endif id="dateEnd" class="datepicker dist_drop" style="border:1px solid #333;width:100%"  size="8"/>
                                                        <!--<input type="text" name="projectname" id="projectname" class="dist_drop" placeholder="Project Name">-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                       
                     <table id="datatable" class="table table-bordered nowrap"
                        style="width: 100%;">
                        <thead>
                           <tr>
                              <th class="text_ellipses">S. No.</th>
                              <th class="text_ellipses_sec" data-toggle="tooltip" title="Project Id">Project Id</th>
                              <th class="text_ellipses_max" data-toggle="tooltip" title="Project Name">Project Name</th>
                              <th>Type</th>
                              <th>Stage</th>
                              <th>Status</th>
                              <th class="text_ellipses_sec" data-toggle="tooltip" title="Created Date">Created Date</th> @if(session('role') == 'employee') @else <th data-orderable="false">Action</th> @endif
                               <th data-orderable="false">View</th>
                           </tr>
                        </thead>
                        <tbody>
                        <!--    <tr>
                              <form method="post">
                                 <td></td> {{ csrf_field() }} <td><input type="text" name="tast_id"
                                       class="width100 form-control"></td>
                                 <td><input type="text" name="project_name" class="width100 form-control"></td>
                                 <td><input type="text" name="emp_name" class="width100 form-control"></td>
                                 <td><input type="text" name="category" class="width100 form-control"></td>
                                 <td><input type="text" name="type" class="width100 form-control"></td>
                                 <td><input type="text" name="last_date" class="width100 form-control"></td>
                                 <td colspan="2"><input type="submit" class="btn btn-primary btn-block" value="search">
                                 </td>
                              </form>
                           </tr> -->
                            <?php $i =  1;?>
                           @foreach($projectlist as $result) <tr>
                              <td>{{$i++}}</td> @if(session('role') == 'employee') <td>{{$result->project_id}}</td>
                              @else <td class="text_ellipses" data-toggle="tooltip" title="PRO-{{$result->project_id}}"><a
                                    href="{{URL::to('/Project-detail/'.$result->id)}}">PRO-{{$result->project_id}}</a></td>
                              @endif <td class="text_ellipses" data-toggle="tooltip" title="{{ucwords($result->project_name)}}">{{ucwords($result->project_name)}}</td>
                              <td>{{$result->project_type}}</td>
                              <td>{{$result->project_stage}}</td>
                              <td class="active-text">{{$result->project_status}}</td>
                              <?php $date = $result->created_date;                                                    $finalDate = explode(' ',$date);                                                    $data = $finalDate[0];                                                    $Dates = date("d-m-Y", strtotime($data));                                                    ?>
                              <td>{{date('d-m-Y h:i:s',strtotime($date))}}</td> @if(session('role') == 'employee') @else <td>


                                      <label class="switch">
                    <input type="checkbox" onclick="change_status(this,'{{$result->id}}')"  class="chebox_true1" @if($result->status==1) checked="" @endif><span class="slider @if($result->status==1) greenactive @endif  userid_{{$result->id}}"></span>
                                                           </label>    


                                           </td> @endif
                              <td> <a title="View" data-toggle="tooltip"
                                    href="{{URL::to('/Project-view/'.$result->id)}}" class="project_det_page m-r-5"><img
                                       src="{{URL::to('assets/images/eye.png')}}" alt="" title=""></a> 
                                       <!-- <a title="Edit"
                                    data-toggle="tooltip" href="{{URL::to('/Project-edit/'.$result->id)}}"
                                    class="project_det_page"><i class="fas fa-edit"></i></a> -->
                                     @if(session('admin') ==
                                 'admin' || session('admin') == 'superadmin') <a title="Delete"
                                    onclick="return confirm('Are you sure you want to Remove?');"
                                    href="{{URL::to('/deleteproject/'.$result->id)}}" class="project_det_page"><i
                                       class="fa fa-trash" aria-hidden="true"></i></a> @endif </td>
                           </tr> @endforeach @if(count($projectlist) == 0) <tr>
                              <td colspan="9">Record Not Found</td>
                           <tr> @endif 
                        </tbody>
                     </table>
                      <div class="row"> @if((session('role') == 'employee') || (session('role') == 'project_Manager'))
                        @else <div class="col-xs-12 col-sm-6">
                           <div class="add_project_new"> <a href="{{URL::to('/Project-add')}}"> Add Project
                                 <span>+</span> </a> </div>
                        </div> @endif
                        <!--  <div class="col-xs-12 col-sm-6">                                            <div class="see_details">                                                <p>Click <a href="project_details.html">here</a> to see project details.</p>                                            </div>                                        </div> -->
                     </div>
                     </div>
                     </div>
                  </div>
               </div>
            </div> <!-- end col -->
            <div class="col-xs-12"> </div>
         </div> <!-- end row -->
      </div> <!-- container-fluid -->
   </div> <!-- content -->
   <!-- <footer class="footer">© 2019 GRC </footer> -->
</div>

 @stop

  @section('extra_js')

     <script type="text/javascript">
          

        $("#dateEnd").change( function() {  

    var dateStart = $('#dateStart').val();
     var dateEnd = $('#dateEnd').val();
     if(dateStart =='' || dateEnd ==''){
      alert('Please Select To and From Date');
      return false;
     }

     $('#date_range').submit();
     

         } );


              $("#dateStart").change( function() {  

    var dateStart = $('#dateStart').val();
     var dateEnd = $('#dateEnd').val();
     if(dateStart =='' || dateEnd ==''){
      alert('Please Select To and From Date');
      return false;
     }

     $('#date_range').submit();
     

         } );
      

        </script>

        <script type="text/javascript">
            
         
          function change_status(element,user_id){

   var result = confirm("Are You Sure to Change Status?");
if (result) {
             
            if($(element).is(":checked")) {

               
              
              $('.userid_'+user_id).addClass('greenactive');
           
             }else{

                 

                  $('.userid_'+user_id).removeClass('greenactive');

             }
             
             $('#loadingDiv').show();

           $.ajax({
   
             url:siteurl+'/public/Project-status/'+user_id,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {

                $('#loadingDiv').hide();
                 alertify.success(response.msg);




                        $.ajax({
   
             url:siteurl+'/public/project-status-email/'+user_id,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {

                // $('#loadingDiv').hide();
                //  alertify.success(response.msg);
                 console.log(response.msg);
                
             }
        });


                
             }
        });
         }

               
        }

        $(document).ready(function() {
    var table = $('#datatable').DataTable();


} );


        </script>

 
        @stop
        
    