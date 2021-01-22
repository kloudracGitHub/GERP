
@extends('superadmin_layout')@section('content')<div class="content-page">
   <!-- Start content -->
   <div class="content p-0">
      <div class="container-fluid">
         <div class="page-title-box">
            <div class="row align-items-center bredcrum-style">
               <div class="col-sm-6 col-6">
                  <h4 class="page-title text-left">Organization</h4>
               </div>
                <div class="col-sm-6 col-6 text-right">

                                <form mathod="GET">
                                    <input type="hidden" name="export" value="export">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-download m-r-5"></i>Export</button>
                                </form>

                            </div>
            </div>
         </div> @if(session::has('msg')) <div class="alert alert-primary alert-dismissible fade show" role="alert">
            {{session::get('msg')}} <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                  aria-hidden="true">&times;</span> </button> </div> @endif @if(session::has('status')) <div
            class="alert alert-{{session::get('alert')}} alert-dismissible fade show" role="alert">
            {{session::get('status')}}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                  aria-hidden="true">&times;</span></button></div> @endif
         <!-- end row -->
         <!-- end row -->
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
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
  <div class="col-sm-12">
                     <table id="datatable" class="datatable table table-bordered nowrap"
                        style="width:100%">
                        <thead>
                           <tr>
                              <th class="text_ellipses">S. No.</th>
                              <th class="text_ellipses_max" title="Organization Id">Org Id</th>
                              <th class="text_ellipses_max" title="Organization Name">Org Name</th>
                              <th class="text_ellipses_max" title="Organization Email">Org Email</th>
                              <th class="text_ellipses_max">Country</th>
                             
                              <th class="text_ellipses_max">Created Date</th>
                              <th data-orderable="false">Action</th>
                              <th data-orderable="false">View</th>
                           </tr>
                        </thead>
                        <tbody>
                            
                           <!-- <tr>-->
                           <!--   <form method="GET">-->
                           <!--      <td></td>  <td><input type="text" name="org_id"-->
                           <!--           ></td>-->
                           <!--      <td><input type="text" name="org_name" ></td>-->
                           <!--      <td><input type="text" name="org_email" ></td>-->
                           <!--      <td><input type="text" name="org_country" ></td>-->
                           <!--      <td><input type="date" name="last_date" ></td>-->
                           <!--      <td ></td>-->
                           <!--      <td colspan="2"><input type="submit"  value="search">-->
                           <!--      </td>-->
                           <!--   </form>-->
                           <!--</tr>-->
                            
                          
                    <?php $key = 1;?> @foreach($Data as
                           $result) <tr>
                              <td>{{$key++}}</td>
                              <td data-toggle="tooltip" title="ORG-{{$result->org_unique_id}}">ORG-{{$result->org_unique_id}}</td>
                              <td data-toggle="tooltip" title="{{ucwords($result->org_name)}}">{{ucwords($result->org_name)}}</td>
                              <td data-toggle="tooltip" title="{{$result->org_email}}">{{$result->org_email}}</td>
                              <td data-toggle="tooltip" title="{{$result->name}}">{{$result->name}}</td>
                              
                              <?php $date = $result->created_date;                                                  $finalDate = explode(' ',$date);                                                  $data = $finalDate[0];                                                 $Dates = date("d-m-Y", strtotime($data));?>
                              <td>{{date('d-m-Y h:i:s',strtotime($date))}}</td>
                              <td>
              
                                  <label class="switch">
                    <input type="checkbox" onclick="change_status(this,'{{$result->organizationid}}')"  class="chebox_true1" @if($result->status==1) checked="" @endif><span class="slider @if($result->status==1) greenactive @endif  userid_{{$result->organizationid}}"></span>
                                                           </label>        


                        
                              </td>
                              <td> <a title="View" data-toggle="tooltip"
                                    href="{{URL::to('/Organization-view/'.$result->organizationid)}}" class="m-r-5"><i
                                       class="fas fa-eye"></i></a> 
                                       <!-- <a title="Edit" data-toggle="tooltip" href="#"
                                    class="project_det_page"><i class="fas fa-edit"></i></a>  -->
                                 </td>
                           </tr> @endforeach  @if(count($Data) == 0) <tr>
                              <td colspan='9' align='center'> <b> No Data Found</b> </td>
                           </tr> @endif
                        </tbody>
                     </table>
                   </div>
                     <div class="add_project_new"> <a href="{{URL::to('/Organization-add')}}"> Add Organization
                           <span>+</span> </a> </div>
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
   
             url:siteurl+'/public/Organization-status/'+user_id,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {

                $('#loadingDiv').hide();
                 alertify.success(response.msg);


              $.ajax({
   
             url:siteurl+'/public/org-status-email/'+user_id,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {

                
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
        
    