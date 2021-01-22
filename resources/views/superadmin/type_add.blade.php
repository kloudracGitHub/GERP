 @extends('superadmin_layout')

   @section('content')


   @if(!empty($type_edit))

@php($text = 'Edit')

   @else

   @php($text = 'add')


   @endif

            <!-- ============================================================== -->

        <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6">

                                <h4 class="page-title">{{$text}} Type</h4>

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

                        @if(Session::has('alert-type'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert-type') }}</p>

                        @endif



                        @if ($message = Session::get('warning-type'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif

                           @if (Session::has('msg'))

                        <div class="alert alert-primary alert-block">

                          <strong>{{ Session::get('msg') }}</strong>

                        </div>

                        @endif

                </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
 <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Add Type
  </a>
  <div class="collapse" id="collapseExample">
  <div class="card-body m-t-10" style="border:1px solid #ededed;">
       <form class="court-info-form width100" id="type_form"  role="form" method="POST" action="{{URL::to('/type-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group m-t-10">

                                               
@if(!empty($type_edit))

<input type="hidden" name="type_id" value="{{$type_edit->id}}">

@endif
                                              

                                                 Type Name

                                                <input type="text" name="type" maxlength="60" class="form-control project_box" autofill="false"   @if(!empty($type_edit)) value="{{$type_edit->type_name}}"   @endif>

                                               

                                               

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6" style="padding: 25px 30px;">

                                            <div class="form-group">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn btn" >

                                            </div>

                                        </div>

                                    </div>

                                    

                                    </div>

                                </form> 
  </div>
</div>
                             
                                
                 <div class="col-sm-12 m-t-10">
                                 <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; margin-top: 92px;">

                                        <thead>

                                            <tr>

                                                <th>S. No.</th>

                                                <th>Type</th>

                                              
                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php $i = 1?>

                                           
                                        @foreach($type as $types)
                                            <tr>

                                                <td>{{$i++}}</td>

                                                <td>{{$types->type_name}}</td>

                                                

                                                 <td>

                                           

                                                     <i data-toggle="modal" data-target="#exampleModal_{{$types->id}}" class="fas fa-edit"></i>


            <div class="modal fade" id="exampleModal_{{$types->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         
                                         <form class="court-info-form width100"  role="form" method="POST" action="{{URL::to('/type-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group m-t-10">

                                               


<input type="hidden" name="type_id" value="{{$types->id}}">


                                              

                                                 Type Name

                                                <input type="text" name="type" maxlength="60" class="form-control project_box" autofill="false"   value="{{$types->type_name}}" >

                                               

                                               

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6 text-right">

                                            <div class="form-group">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn" >

                                            </div>

                                        </div>

                                    </div>

                                    

                                    </div>

                                </form> 

             </div>

    </div>
  </div>
</div>

                                                    <a onclick="return confirm('Are you sure you want to delete this Type?');" href="{{URL::to('delete_type')}}/{{$types->id}}"><i class="mdi mdi-delete text-danger"  title="Delete"></i></a>

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
  $("#type_form").validate({
    rules: {
      type : {
        required: true,
        
      },
     
       
      
    },
  
  });
});
   

   


</script>

@stop