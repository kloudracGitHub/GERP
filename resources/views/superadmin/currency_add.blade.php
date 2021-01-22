 @extends('superadmin_layout')

   @section('content')

            <!-- ============================================================== -->
            
            @if(!empty($currency_edit))
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

                                <h4 class="page-title">{{$text}} Currency</h4>

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



                        @if (Session::has('warning-currency'))

                        <div class="alert alert-primary alert-block">

                          <strong>{{ Session::get('warning-currency') }}</strong>

                        </div>

                        @endif

                </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
 <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Add Currency
  </a>
  <div class="collapse" id="collapseExample">
  <div class="card-body m-t-10" style="border:1px solid #ededed;">
      <form class="court-info-form width100" id="currency_form"  role="form" method="POST" action="{{URL::to('/currency-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                               

                                              

                                                 Currency Name

                                                <input type="text"  @if(!empty($currency_edit)) value="{{$currency_edit->currencyname}}"   @endif name="currency" maxlength="50"  class="form-control project_box" autofill="false">

                                               

                                               

                                            </div>

                                        </div>

                                        

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                               @if(!empty($currency_edit))
                                               <input type="hidden" name="currency_id" value="{{$currency_edit->id}}">
                                               @endif

                                              

                                                Currency Code

                                                <input type="text" name="currency_code" maxlength="5"  class="form-control project_box" autofill="false"   @if(!empty($currency_edit)) value="{{$currency_edit->currencycode}}"   @endif>

                                               

                                               

                                            </div>

                                        </div>

</div>
<div class="row">
                                        <div class="col-xs-12 col-sm-6"></div>



                                        <div class="col-xs-12 col-sm-6 text-right">

                                            <div class="form-group">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn" >

                                            </div>

                                        </div>
</div>


                                  

                                    

                                </form> 
  </div>
</div>
                               
  </div>
</div>
<div class="row">
  <div class="col-sm-12 m-t-20">
                             <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>

                                            <tr>

                                                <th>S. No.</th>

                                                <th>Currency Name</th>
                                                 <th>Currency Code</th>

                                                

                                                <th>Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php $i = 1?>
                                            @foreach($currency_list as $currency_lists)
                                           

                                            <tr>

                                                <td>{{$i++}}</td>

                                                <td>{{$currency_lists->currencyname}}</td>

                                                <td>{{$currency_lists->currencycode}}</td>

                                                 <td>

                                                   <!--   <a href="{{URL::to('currency-management?edit=')}}{{$currency_lists->id}}"><i class="fas fa-edit"></i></a> -->


                                                     <i data-toggle="modal" data-target="#exampleModal_{{$currency_lists->id}}" class="fas fa-edit"></i>


                                                     


  <div class="modal fade" id="exampleModal_{{$currency_lists->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form class="court-info-form width100"  role="form" method="POST" action="{{URL::to('/currency-management')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                               

                                              

                                                 Currency Name

                                                <input type="text"   value="{{$currency_lists->currencyname}}"    name="currency" maxlength="50"  class="form-control project_box" autofill="false">

                                               

                                               

                                            </div>

                                        </div>

                                        

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                             <input type="hidden" name="currency_id" value="{{$currency_lists->id}}">

                                              

                                                Currency Code

                                                <input type="text" name="currency_code" maxlength="5"  class="form-control project_box" autofill="false"    value="{{$currency_lists->currencycode}}"   >

                                               

                                               

                                            </div>

                                        </div>

</div>
<div class="row">
                                        <div class="col-xs-12 col-sm-6"></div>



                                        <div class="col-xs-12 col-sm-6 text-right">

                                            <div class="form-group">

                                        

                                                <input type="submit" name="submit" value="Submit" class="submit_btn" >

                                            </div>

                                        </div>
</div>


                                  

                                    

                                </form>
      </div>

    </div>
  </div>
</div>

                                                    <a onclick="return confirm('Are you sure you want to delete this Currency?');" href="{{URL::to('delete_currency')}}/{{$currency_lists->id}}"><i class="mdi mdi-delete text-danger"  title="Delete"></i></a>

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
  $("#currency_form").validate({
    rules: {
      currency : {
        required: true,
        
      },
      currency_code : {
        required: true,
        
      },
       
      
    },
  
  });
});
   

    $(".checkbox-dropdown").click(function () {

        $(this).toggleClass("is-active");

    });



    $(".checkbox-dropdown ul").click(function(e) {

        e.stopPropagation();

    });



</script>

@stop