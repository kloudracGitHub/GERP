  @extends('superadmin_layout')
   @section('content') 
  <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style m-b-20 p-10">
                            <div class="col-sm-6">
                                <h4 class="page-title">Add Circular</h4>
                            </div>
                        </div>
                    </div>
                    
                        @if (session::has('msg'))
                   <div class="alert alert-primary">
                  {{session::get('msg')}}
                   </div>
                   @endif
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"> 
                        <div class="card">
                             <div class="card-body">
                            <div class="add_circular_wrapper">
                                <div class="add_circular_icon">
                                   
                                </div>
                                 <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Add Circular
  </a>
  <div class="collapse" id="collapseExample">
  <div class="card-body m-t-10" style="border:1px solid #ededed;">
      <form class="court-info-form" id="addCircular_form" role="form" method="POST" action="{{URL::to('/circular')}}"  enctype="multipart/form-data">   
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="inner_circular_wrapper">
                                        <div class="row">    
                                            <div class="col-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <textarea name="addCircular"  maxlenght="500" class="form-control" placeholder="Enter Circular" ></textarea>
                                                  
                                                   
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="profile_image">Files</label>
                                                <input type="file" name="circularimage" >

                                          
                                                                                         </div>

                                        </div>

                                        </div>
                                    </div>

                                    <div class="submit_circular">
                                        <input type="submit" name="submitCircular" maxlenght="500" id="submitCircular" class="circular_btn" value="Save">
                                    </div>
                                </form>
  </div>
</div>
                             
                                </div>
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
                                            <div class="col-sm-12 text-center m-b-10 p-0">
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
<div class="">
                                        <table id="datatable" class="datatable table table-bordered nowrap"
                        style="width: 100%;">
                                                 <thead>
                                                <tr>
                                                    <th scope="col" class="text_ellipses">S No.</th>
                                                    <th scope="col" class="text_ellipses_max">Circulars</th>
                                                    <th scope="col" class="text_ellipses_sec">Attachment</th>
                                                    <th scope="col" class="text_ellipses_sec">Created Date</th>
                                                    <th scope="col" data-orderable="false">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1?>
                                                @foreach($updateData as $result)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                <td class="text_ellipses" title="{{$result->circular_name}}" data-toggle="tooltip">{{$result->circular_name}}</td>
                                                <td>
                                                @if(!empty($result->attachment))
                                                <a href="{{URL::to('/attachement')}}/{{$result->attachment}}"> {{$result->attachment}}</a>
                                               @else

                                               Not Available
                         

                                               @endif
                                                </td>
                                                 <?php $date = $result->created_date;
                                                     $finalDate = explode(' ',$date);
                                                     $data = $finalDate[0];
                                                    $Dates = date("d-m-Y", strtotime($data));?>
                                                <td>{{date('d-m-Y h:i:s',strtotime($date))}}</td>
                                                 <td>
                                                    <a href="{{URL::to('/circular-delete/'.$result->id)}}"><i class="mdi mdi-delete text-danger" data-toggle="modal" onclick="return confirm('Are you sure you want to delete');"
                                                               data-target="#deletemp" title="Delete"></i></a>
                                                </td>
                                                </tr>
                                               @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->
        </div>
        @stop

        @section('extra_js')

        <script type="text/javascript">



        $(document).ready(function() {
  $("#addCircular_form").validate({
    rules: {
      addCircular : {
        required: true,
        
      },
       task_upload : {
        required: true,
        
        
      },

   
    },

  });
});
    </script>

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

        @stop