    @extends('superadmin_layout')

    @section('extra_css')
<style type="text/css">
  /*div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }*/
  
  </style>
  @stop
  @section('content')
  <div class="content-page">
    <!-- Start content -->
    <div class="content p-0">
      <div class="container-fluid">
        <div class="page-title-box">
          <div class="row align-items-center bredcrum-style">
            <div class="col-sm-6 col-6">
              <h4 class="page-title text-left">Users</h4>
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

      <div class="alert alert-{{session::get('alert')??'primary'}} alert-dismissible fade show" role="alert">
        {{session::get('msg')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      @endif

      <div class="add_project_name">
        <div class="row">
          <?php $count = DB::table('grc_organization')->where('id',session('org_id'))->first();?>
          <div class="col-xs-12 col-sm-12 text-right">
            @if(session('role') == 'admin' || session('role') == 'project_Manager' || session('role') == 'employee')
            <h2>{{$count->org_name??0}}</h2>

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
              <table id="datatable" class="datatable table table-bordered nowrap" style="width: 100%;">
                <thead>
                  <tr>
                    <th class="text_ellipses">S. No.</th>
                    <th class="text_ellipses">Emp id</th>
                    <th class="text_ellipses_max" data-toggle="tooltip" title="First Name">First Name</th>
                    <th class="text_ellipses_max" data-toggle="tooltip" title="Last Name">Last name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th data-orderable="false">Action</th>
                    <th data-orderable="false">View</th>
                  </tr>
                </thead>
                <tbody>
                 <?php $i =  1;?>
                 @foreach($user_list as  $usera)
                 <tr>
                  <td>{{$i++}}</td>
                  <td class="text_ellipses" data-toggle="tooltip" title="EMP-{{$usera->employee_id}}">EMP-{{$usera->employee_id}}</td>
                  <td>{{ucwords($usera->first_name)}}</td>
                  <td class="text_ellipses_sec" data-toggle="tooltip" title="{{ucwords($usera->last_name)}}">{{ucwords($usera->last_name)}}</td>
                  <td>{{$usera->email}}</td>
                  <td>{{$usera->mobile_no}}</td>
                  <td>{{($usera->role=='employee')?'Users':ucwords(str_replace('_',' ',$usera->role) )}}</td>
                  <td>

                    <label class="switch">
                      <input type="checkbox" onclick="change_status(this,'{{$usera->id}}')"  class="chebox_true1" @if($usera->status==1) checked="" @endif><span class="slider @if($usera->status==1) greenactive @endif  userid_{{$usera->id}}"></span>
                    </label>                                                



                  </td>
                  <td>							<a  title="View" data-toggle="tooltip" href="{{URL::to('/Users-view/'.$usera->id)}}" class="project_det_page m-r-5"><img src="{{URL::to('assets/images/eye.png')}}" alt="" title=""></a>											</td>
                </tr>
                @endforeach



              </tbody>
            </table>
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <div class="add_project_new">
                  <a href="{{URL::to('/Users-add')}}">
                    Add User
                    <span>+</span>
                  </a>
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

@section('extra_js')

<script type="text/javascript">


  function change_status(element,user_id){

    var result = confirm("Are You Sure to Change Status?");
    if (result) {
    //Logic to delete the item


    if($(element).is(":checked")) {



      $('.userid_'+user_id).addClass('greenactive');

    }else{



      $('.userid_'+user_id).removeClass('greenactive');

    }

    $('#loadingDiv').show();

    $.ajax({

     url:siteurl+'/public/Users-status/'+user_id,

     type: "GET",

     cache: false,

     dataType: 'json',

     success: function (response) {

      $('#loadingDiv').hide();
      alertify.success(response.msg);



     $.ajax({

     url:siteurl+'/public/user-status-email/'+user_id,

     type: "GET",

     cache: false,

     dataType: 'json',

     success: function (response) {

      
      console.log(response.msg);

    }
  })



    }
  })

  }


}

$(document).ready(function() {
  var table = $('#datatable').DataTable();


} );


</script>



@stop

