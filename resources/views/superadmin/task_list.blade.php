 



 @extends('superadmin_layout')

   @section('content')


@section('extra_css')

@stop


 <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6 col-6">

                                <h4 class="page-title text-left">Tasks</h4>

                            </div>
                            <div class="col-sm-6 col-6 text-right">

                              <form mathod="GET">
                                    <input type="hidden" name="export" value="export">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-download m-r-5"></i>Export</button>
                                </form>

                            </div>
                        </div>

                    </div>



                    @if(session::has('msg'))



                    <div class="alert alert-warning alert-dismissible fade show" role="alert">

 {{session::get('msg')}}

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">

    <span aria-hidden="true">&times;</span>

  </button>

</div>

                    @endif

                    

                     @if(session::has('status'))



                    <div class="alert alert-{{session::get('alert')}} alert-dismissible fade show" role="alert">

 {{session::get('status')}}

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">

    <span aria-hidden="true">&times;</span>

  </button>

</div>

                    @endif

                    @if(isset($task_list) && !empty($task_list))

                    <div class="add_project_name">

                         <?php $count = DB::table('grc_organization')->where('id',session('org_id'))->first();?>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12">

                                 @if(session('role') == 'admin' || session('role') == 'project_Manager' || session('role') == 'employee')

                                <h2>{{$count->org_name??''}}</h2>

                                
                                @endif

                            </div>

                        </div>

                    </div>

                    <!-- end row -->

                    <!-- end row -->

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">

                                    <table id="datatable" class="table table-bordered nowrap"
                                        style="width: 100%;">

                                        <thead>

                                            <tr>

                                                <th class="text_ellipses_sec">S. No.</th>

                                                <th class="text_ellipses_sec">Task id</th>

                                                <th class="text_ellipses_max">Task Name</th>

                                                <th>Project</th>

                                                <th>Employee</th>

                                                <th>Category</th>

                                                <th>Type</th>

                                                <th class="text_ellipses_sec" title="Last Date">Last Date</th>

                                                <th data-orderable="false" class="text_ellipses_sec" title="Task Status">Task Status</th>

                                                <th data-orderable="false">Status</th>

                                                <th data-orderable="false">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>



                                          <!--   <tr>

                                                <form method="post">

                                                <td></td>

                                                



                                             {{ csrf_field() }}                                             

					<td><input type="text" name="tast_id" class="width100 form-control"></td>

                    <td><input type="text" name="tast_name" class="width100 form-control"></td>

                                                <td><input type="text" name="project_name" class="width100 form-control"></td>

                                                <td><input type="text" name="emp_name" class="width100 form-control"></td>

                                                <td><input type="text" name="category" class="width100 form-control"></td>

                                                <td><input type="text" name="type" class="width100 form-control"></td>

                                                <td><input type="text" name="last_date" class="width100 form-control"></td>

                                                <td colspan="2"><input type="text" name="status" class="width100 form-control"></td>

                                                

                                                <td><input type="submit" class="btn btn-primary" value="search"></td>

                                                </form>

                                            </tr>
 -->
                                            

                                           

                                               <?php $i =  1;?>

                                            @foreach($task_list as $tasklist)

                                            <tr>

                                                <td>{{$i++}}</td>

                                                <td data-toggle="tooltip" title="TSK-{{$tasklist->task_id}}"><a href="{{URL::to('/Task-detail/'.$tasklist->id)}}">TSK-{{$tasklist->task_id}}</a></td>

                                                 <td  class="text_ellipses_max" data-toggle="tooltip" title="{{ucwords($tasklist->task_name)}}">{{ucwords($tasklist->task_name)}}</td>

                                                 <td>{{ucwords($tasklist->project_name)}}</td>

                                               

                                                 <td>{{ucwords($tasklist->first_name)}} {{ucwords($tasklist->middle_name)}} {{ucwords($tasklist->last_name)}}</td>

                                                <td>{{$tasklist->category}}</td>

                                                <td>{{$tasklist->type}}</td>

                                                <td>{{date('d-m-Y',strtotime($tasklist->end_date))}}</td>

                                                <?php 

                                                $createddate = strtotime($tasklist->created_date);

                                                $taskdate = strtotime($tasklist->estimated_hrs);

                                                

                                                    $currentdate = strtotime(date("Y-m-d"));



                                                    

                                                ?>



                                               

                                               <!--  <td><span class="task_status task_pending"></span></td> -->

                                    

                                                @if($currentdate>$taskdate+$createddate)

                                                @if($tasklist->task_status == 'Cannot Not Be Completed')

                                                  

                                                  <?php $updateD = DB::table('grc_task')->where('id',$tasklist->id)->first();



                                               $ff = $updateD->task_not_completed;



                                               //echo $ff; die('sdf');

                                            if(empty($ff)){?>

                                            <!--  <script>

// your "Imaginary javascript"

 window.location.href = '{{url("/taskcannotbecompleted/".$tasklist->id)}}';

 //using a named route

</script> -->

                                            <?php  } ?>

                                            

                                                @endif

                                                <td><span class="task_status task_complete"></span></td>



                                                @else

                                                <?php  $updateDataas = DB::table('grc_task')->where('id',$tasklist->id)->first();

                                                     $redstatus = $updateDataas->red_mark_status;

                                                        

                                                     if(empty($redstatus)){

                                                      ?>

                                                    <!--   <script>

// your "Imaginary javascript"

 window.location.href = '{{url("/checktask/".$tasklist->id)}}';

 //using a named route

</script> -->

                                                      <?php

                                                     } ?>

                                                    

                                                <td><span class="task_status task_incomplete"></span></td>

                                                @endif

                                                

                                                

                                                <td class="active-text">{{$tasklist->task_status}}</td>

                                                <td>


                                                      <label class="switch">
                    <input type="checkbox" onclick="change_status(this,'{{$tasklist->id}}')"  class="chebox_true1" @if($tasklist->status==1) checked="" @endif><span class="slider @if($tasklist->status==1) greenactive @endif  userid_{{$tasklist->id}}"></span>
                                                           </label>    

                                                    <label class="switch">

                                                        

                                                                                                            

                                                    </label>

                                                </td>

                                            </tr>

                                           

                                           @endforeach

                                           

                                        </tbody>

                                    </table>

                                       @if(session('role') == 'employee')



                                                @else

                                    <div class="add_project_new">

                                        <a href="{{URL::to('/Task-add')}}">

                                            Add Tasks

                                            <span>+</span>

                                        </a>

                                    </div>

                                    @endif

                                </div>
                            </div>

                        </div>

                        <!-- end col -->



                        <div class="col-xs-12">



                        </div>

                    </div>

                    @else

                    

                    

                    Task Not Found

                    

                    @endif

                    <!-- end row -->

                </div>

                <!-- container-fluid -->

            </div>

            <!-- content -->

            <!-- <footer class="footer">© 2019 GRC </footer> -->

        </div>

   @stop


    @section('extra_js')

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
   
             url:siteurl+'/public/task-status/'+user_id,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {

                $('#loadingDiv').hide();
                 alertify.success(response.msg);
                
             }
        });
         }

               
        }

        $(document).ready(function() {
    var table = $('#datatable').DataTable();


} );


        </script>


        @stop
        
    