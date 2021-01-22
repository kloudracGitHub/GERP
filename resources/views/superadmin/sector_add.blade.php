 @extends('superadmin_layout')

   @section('content')

            <!-- ============================================================== -->
        

            @if(!empty($sector_edit))

            @php($text = 'Edit')

            @else

            @php($text = 'Add')

            @endif



        <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6">

                                <h4 class="page-title">{{$text}} Sector</h4>

                            </div>

                           

                        </div>

                    </div>

                </div>

                <div class="add_project_wrapper add_org_wrapper">

                    <div class="container-fluid">

                        @if ($errors->any())

                   <div class="alert alert-danger">

                   <ul>

                   @foreach ($errors->all() as $error)

                   <li>{{ $error }}</li>

                   @endforeach

                   </ul>

                   </div>

                   @endif

                         <div class="col-xs-8">

                        @if(Session::has('alert-currency'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert-currency') }}</p>

                        @endif



                        @if ($message = Session::get('warning-currency'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif

                            @if(Session::has('msg'))

                        <p class="alert alert-info">{{ Session::get('msg') }}</p>

                        @endif

                </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Add Sector
  </a>
  <div class="collapse" id="collapseExample">
  <div class="card-body m-t-10" style="border:1px solid #ededed;">
      <form class="court-info-form width100" id="sector_form" role="form" method="POST" action="{{URL::to('/sector-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                               

                                @if(!empty($sector_edit))

                             <input type="hidden" name="sector_id" value="{{$sector_edit->id}}">
                                @endif              

                                                 Sector Name

                                                <input type="text" name="sector" maxlenght="60" class="form-control project_box" autofill="false"   @if(!empty($sector_edit))


                                                 value="{{$sector_edit->sector_name}}"   @endif>

                                               

                                               

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group m-t-10">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn">

                                            </div>

                                        </div>

                                    </div>

                                    

                                    </div>

                                </form>  
  </div>
</div>
                        
                              
                                <div class="col-sm-12 m-t-10">
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                          
                                        <thead>

                                            <tr>

                                                <th>S. No.</th>

                                                <th>Sector</th>

                                              

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php $i = 1?>

                                                @foreach($sector_list as $sector_lists)

                                            <tr>

                                                <td>{{$i++}}</td>

                                                <td>{{$sector_lists->sector_name}}</td>

                                               
                                                 <td>

                                                  
                                                 

                                                      <i data-toggle="modal" data-target="#exampleModal_{{$sector_lists->id}}" class="fas fa-edit"></i>


            <div class="modal fade" id="exampleModal_{{$sector_lists->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         
     <form class="court-info-form width100"  role="form" method="POST" action="{{URL::to('/sector-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                               


                             <input type="hidden" name="sector_id" value="{{$sector_lists->id}}">
                                       

                                                 Sector Name

                                                <input type="text" name="sector" maxlenght="60" class="form-control project_box" autofill="false"   


                                                 value="{{$sector_lists->sector_name}}"  >

                                               

                                               

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6 text-right">

                                            <div class="form-group m-t-10">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn">

                                            </div>

                                        </div>

                                    </div>

                                    

                                    </div>

                                </form> 
             </div>

    </div>
  </div>
</div>



                                                    <a onclick="return confirm('Are you sure you want to delete this Sector?');" href="{{URL::to('delete_sector')}}/{{$sector_lists->id}}"><i class="mdi mdi-delete text-danger"  title="Delete"></i></a>


                                                </td>

                                            </tr>

                                            @endforeach

                                          

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div>

                        <!-- end row -->

                    </div>

                </div>

                <!-- container-fluid -->

            </div>

            <!-- content -->

            <!-- <footer class="footer">© 2019 GRC </footer> -->

        </div>

        <!-- ============================================================== -->

        <!-- End Right content here -->

        <!-- ============================================================== -->

    </div>

   

</div>

<!-- /.modal-dialog -->

</div>

@stop

@section('extra_js')

<script>


    $(document).ready(function() {
  $("#sector_form").validate({
    rules: {
      sector : {
        required: true,
        
      },
     
       
      
    },
  
  });
});
   

   


</script>

@stop