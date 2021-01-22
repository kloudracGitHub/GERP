 @extends('superadmin_layout')

   @section('content')

    <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6">

                                <h4 class="page-title">Add Country</h4>

                            </div>

                        </div>

                    </div>

                </div>

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

                        @if(Session::has('alert-success'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert-success') }}</p>

                        @endif

                        

                        @if(Session::has('delete-country'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('delete-country') }}</p>

                        @endif



                        @if ($message = Session::get('countries-deleted'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif

                </div>

                        <div class="row">
                            <div class="col-12">
<div class="card">
    <div class="card-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="system_setting_page m-t-10">
                                      <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Add Country
  </a>
  <div class="collapse" id="collapseExample">
  <div class="card-body m-t-10" style="border:1px solid #ededed;">
     <form class="court-info-form" id="country_form" role="form" method="POST" action="{{URL::to('/country')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row ">
<div class="col-sm-6">
	<div class="checkbox-dropdown" style="width:100%">

                                            Choose Country

                                         

                                            <ul class="checkbox-dropdown-list">

                                                @foreach($Data as $result)

                                                @if(!in_array($result['id'],$existcountryid))

                                                <li>

                                                    <label>

                                                        <input type="checkbox" value="{{$result['id']}}" name="countryname[]" />{{$result['name']}}

                                                    </label>

                                                </li>

                                                @endif

                                                @endforeach

                                                <li>

                                                   

                                            </ul>

                                        </div>
                                    </div>
<div class="col=sm-6 add_project_wrapper" style="width:50%;padding: 25px 30px;">
                                        <input type="submit" name="submit" value="Submit" class="btn submit_btn" >
</div>
</div>
                                    </form>
  </div>
</div>
                                    

                                    <div class="table-responsive m-t-20">

                                      <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>

                                                <tr>

                                                    <th scope="col">S No.</th>

                                                    <th scope="col">Country</th>

                                                    <th scope="col">Created Date</th>

                                                    <th scope="col">Action</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                

                                                <?php $i = 1?>

                                                @foreach($CData as $result)

                                                <tr>

                                                    <td>{{$i++}}</td>

                                                <td>{{$result['countryname']}}</td>

                                                <td>{{$result['createdate']}}</td>

                                                 <td>

                                                    <a onclick="return confirm('Are you sure you want to delete ?');" href="{{URL::to('/country-delete/'.$result['countryid'])}}"><i class="mdi mdi-delete text-danger" data-toggle="modal"

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

                        <!-- end row -->

                    </div>

                

                <!-- container-fluid -->

            </div>

            <!-- content -->

            <!-- <footer class="footer">© 2019 GRC </footer> -->

        </div>

@stop



<script>

    $(".checkbox-dropdown").click(function () {

        $(this).toggleClass("is-active");

    });



    $(".checkbox-dropdown ul").click(function(e) {

        e.stopPropagation();

    });



</script>