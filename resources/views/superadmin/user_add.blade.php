  @extends('superadmin_layout')

   @section('content')

    <?php $con_list = DB::table('grc_superadmin_country_list')->join('alm_countries','grc_superadmin_country_list.country_id','=','alm_countries.id')->

                                            get();?>

 <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6">

                                <h4 class="page-title">Add User</h4>

                            </div>

                            <div class="col-sm-6">

                                <h4 class="page-title project_super"></h4>

                            </div>

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

                <div class="add_project_wrapper">

                    <div class="container-fluid">

                      

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <form class="court-info-form" id="add_users"  role="form" method="POST" action="{{URL::to('/Users-add')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="row">

                                 
<!-- 
                                        <div class="col-xs-12 col-sm-6">

                                             @if(session('role') == 'admin' || session('role') == 'project_Manager')

                                            <div class="form-group">

                                                <?php $org_list = DB::table('grc_organization')->get();

                                                   // echo(session('org_id')); die('dgfsd');

                                                ?>

                                                <label for="fname">Organization Name</label>



                                                <select name="org_name" id="org_name" class="form-control project_box" disabled="true">

                                                    <option value="">Please Select...</option>

                                                    @foreach($org_list as $org)

                                                    <option value="{{$org->id}}" @if(session('org_id') == $org->id) selected @endif>{{$org->org_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('org_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                            @else

                                            <div class="form-group">

                                                <?php $org_list = DB::table('grc_organization')->get();?>

                                                <label for="fname">Organization Name</label>



                                                <select name="org_name" id="org_name"  class="form-control project_box">

                                                    <option value="">Please Select...</option>

                                                    @foreach($org_list as $org)

                                                    <option value="{{$org->id}}">{{$org->org_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('org_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                            @endif

                                        </div> -->

                                     <!--    @if(session('role') == 'admin' || session('role') == 'project_Manager')

                                        <div class="col-xs-12 col-sm-6">

                                            <?php $pro_list = DB::table('grc_project')->where('organization_id',session('org_id'))->get();?>

                                            <div class="form-group">

                                                <label for="fname">Project Name</label>

                                                <select name="pro_name" id="pro_name"  class="form-control project_box">

                                                    <option value=" ">Please Select...</option>

                                                    @foreach($pro_list as $pro)

                                                    <option value="{{$pro->id}}">{{$pro->project_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('pro_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>

                                        @else

                                        <div class="col-xs-12 col-sm-6">

                                            <?php $pro_list = DB::table('grc_project')->get();?>

                                            <div class="form-group">

                                                <label for="fname">Project Name</label>

                                                <select name="pro_name" id="pro_name" class="form-control project_box">

                                                    <option value="">Select Option</option>

                                                    @foreach($pro_list as $pro)

                                                    <option value="{{$pro->id}}">{{$pro->project_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('pro_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>

                                        @endif

                                                
 -->


                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="fname">First Name</label><span style="color:red">*</span>

                                                <input type="text" name="fname" id="fname" value="{{ old('fname') }}" maxlength="60" class="form-control project_box">
                                                <div id="fname_error"></div>

                                                 @error('fname')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="fname">Middle Name</label>

                                                <input type="text" name="mname" id="mname" value="{{ old('mname') }}"  maxlength="60" class="form-control project_box">

                                                

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="lname">Last Name</label><span style="color:red">*</span>

                                                <input type="text" name="lname" id="lname" value="{{ old('lname') }}" maxlength="60" class="form-control project_box">
                                                <div id="lname_error"></div>
                                                 @error('lname')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                     <!--    <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="fname">User Name</label><span style="color:red">*</span>

                                                <input type="text" name="uname" id="uname" value="{{ old('uname') }}" maxlength="60" class="form-control project_box">

                                                 @error('uname')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div> -->

                                        

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="emailaddress">Email Address</label><span style="color:red">*</span>

                                                <input type="text" name="emailaddress" id="emailaddress" value="{{ old('emailaddress') }}" maxlength="60" class="form-control project_box">
                                    <div id="emailaddress_error"></div>
                                                 @error('emailaddress')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="emailaddress">Alternate Email</label>

                                                <input type="text" name="alt_emailaddress" id="alt_emailaddress" value="{{ old('emailaddress') }}" maxlength="60" class="form-control project_box">
                                              
                                                

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="emailaddress">Role</label><span style="color:red">*</span>

                                                <select name="role" id="role" onchange="get_role(this.value)"  class="form-control project_box">

                                                    <option value="">Select Option</option>

                                                     @if(session('role') == 'superadmin')

                                                    <option value="admin">Admin</option>

                                                    <option value="project_Manager">Project Manager</option>

                                                    <option value="employee">User</option>
                                                 @elseif(session('role') == 'project_Manager')
                                                     <option value="employee">User</option>
                                                    @else

                                                     <option value="project_Manager">Project Manager</option>

                                                    <option value="employee">User</option>

                                                    

                                                    @endif

                                                </select>

                                             <div id="role_error"></div>

                                                 @error('role')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>

                                          @if(session('role') == 'superadmin')


                                           <div class="col-xs-12 col-sm-6" id="org_hide" style="display:none;">

                                            <?php $org_list = DB::table('grc_organization')->where('status',1)->get();?>

                                            <div class="form-group">

                                                <label for="fname">Organization Name</label>

                                                <select name="org_id" id="org_id" class="form-control project_box">

                                                    

                                                   @foreach($org_list as $org)

                                                    <option value="{{$org->id}}">{{$org->org_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('pro_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>


                                          @endif



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Mobile No.</label><span style="color:red">*</span>
<div class="row">
    <div class="col-sm-4">
        <select class="form-control project_box" name="pre_mob">
            @foreach($con_list as $con_lists)
            <option value="{{$con_lists->phonecode}}">+{{$con_lists->phonecode}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-8">
                                                        <input type="text" onkeypress="preventNonNumericalInput(event)" name="mobile" id="mobile" value="{{ old('mobile') }}" maxlength="10" class="form-control project_box">
    </div>
</div>

                                            </div>

                                            <div id="mobile_error"></div>

                                             @error('mobile')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Alternate No.</label>
<div class="row">
    <div class="col-sm-4">
       <input type="text" class="form-control project_box" name="pre_alt_mob"  maxlength="5">
    </div>
    <div class="col-sm-8">
                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="alternate" id="alternate"  value="{{ old('alternate') }}" maxlength="10" class="form-control project_box">
    </div>
</div>

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Pancard No.</label><span style="color:red">*</span>

                                                <input type="text" name="pancard" id="pancard"  value="{{ old('pancard') }}" maxlength="10" class="form-control project_box">
                                    <div id="pancard_error"></div>
                                                 @error('pancard')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Aadhaar Card No.</label><span style="color:red">*</span>

                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="adhaar" id="adhaar"  value="{{ old('adhaar') }}" maxlength="12" class="form-control project_box">
                                            <div id="adhaar_error"></div>
                                                 @error('adhaar')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Designation</label>

                                                <input type="text" name="designation" id="designation" value="{{ old('designation') }}" maxlength="60" class="form-control project_box">

                                               

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">DOB</label><span style="color:red">*</span>

                                                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" placeholder="dd/mm/yyyy" class="dateTxt form-control project_box">
                                            <div id="dob_error"></div>
                                                 @error('dob')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Gender</label><span style="color:red">*</span>

                                                <select name="gender" id="gender" class="form-control project_box">

                                                    <option value="">Select Option</option>

                                                    <option value="Female">Female</option>

                                                    <option value="Male">Male</option>

                                                </select>
                                                <div id="gender_error"></div>
                                                 @error('gender')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">Address</label><span style="color:red">*</span>

                                                <input type="text" name="address" id="address" value="{{ old('address') }}" maxlength="200"  class="form-control project_box">
                                            <div id="address_error"></div>
                                                 @error('address')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                           

                                            <div class="form-group">

                                                <label for="phonenumber">Country</label><span style="color:red">*</span>

                                                <select name="country" id="empcountry" class="form-control project_box">

                                                    <option value="">Select Option</option>

                                                    @foreach($con_list as $val)

                                                    <option value="{{$val->id}}">{{$val->name}}</option>

                                                    @endforeach

                                                </select>


                                             <div id="empcountry_error"></div>
                                                 @error('country')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">State</label><span style="color:red">*</span>

                                                 <select name="state" id="empstate" class="form-control project_box statelist">

                                                     

                                                        <option value="">Select Option</option>

                                                 </select>

  <div id="empstate_error"></div>

                                                  @error('state')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                                

                                            </div>

                                        </div>



                                         <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="phonenumber">City</label><span style="color:red">*</span>

                                                 <select name="city" id="city" class="form-control project_box citylist" >

                                                     <option value="">Select Option</option>

                                                 </select>

                                    <div id="city_error"></div>

                                                @error('city')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="landmark">Landmark</label>

                                                <input type="text" name="landmark" id="landmark" value="{{ old('landmark') }}" maxlength="200" class="form-control project_box">

                                                 

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="pincode">Pin Code</label><span style="color:red">*</span>

                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="pincode" id="pincode" value="{{ old('pincode') }}" maxlength="6" class="form-control project_box">
                                         <div id="pincode_error"></div>
                                                 @error('pincode')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="profile_image">Profile Image</label>

                                                <input type="file" name="profileimage"   onchange="return ValidateFileUpload()" id="fileChooser">



                                             <img src="" id="blah" width="67px">

                                            

                                            </div>



                                        </div>



                                        <div class="col-xs-12 col-sm-12 text-center">

                                                <button type="button" id="user_preview" class="previvew_btn" onclick="getuserValue();">Preview</button>

                                              

                <button type="submit"  class="submit_btn ">Submit</button>

                                        </div>



                                    </div>

                                </form> 

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



<!------------------------------------------>

<!-------------- Preview Modal ------------->

<!------------------------------------------>

<div class="modal fade bd-example-modal-xl" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">

        <div class="modal-content">

            <div class="modal-header">
                 <h5 class="modal-title mt-0 header_color" id="myModalLabel">User Preview</h5>
            </div>

            <div class="modal-body">

                <div class="preview_mode">

                    <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">First Name</label>
   <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="userfname"></label>
</div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Last Name</label>
 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="userlname"></p>
</div>
                            </div>

                        </div>

                    </div>
                  
<div class="row b-b">
                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Email Address</label>
 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="useremail"></label>
</div>
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Mobile No.</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="usermobile"></label>
</div>
                            </div>

                        </div>
</div>
                        
<div class="row b-b">
                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> Role</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewrole"></label>
</div>
                            </div>

                        </div>

                       

                             <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> Alternate No.</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="altmobile"></label>
</div>
                            </div>

                        </div>
</div>
                        
<div class="row b-b">
                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Pancard No.</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="pencard"></label>
                                </div>

                            </div>

                        </div>

                        

                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> Aadhaar Card No.</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="addhar"></label>
</div>
                            </div>

                        </div>
</div>
                        
<div class="row b-b">
                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> Designation</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewdesignation"></label>
</div>
                            </div>

                        </div>

                        

                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> DOB</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewdob"></label>
</div>
                            </div>

                        </div>

                     </div>   
<div class="row b-b">
                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label"> Gender</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewgender"></p>
</div>
                            </div>

                        </div>

                        

                              <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Address</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewaddress"></label>
                                </div>

                            </div>

                        </div>
</div>
      <div class="row b-b">                  

                         <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Country</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="country"></label>
</div>
                            </div>

                        </div>

                        

                        

                         <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">State</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="state"></label>
</div>
                            </div>

                        </div>
</div>
<div class="row b-b">
                        

                         <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">City</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="viewcity"></label>
</div>
                            </div>

                        </div>

                        

                 

                        

                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Pin Code</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="userpincode"></label>
</div>
                            </div>

                        </div>
</div>
<div class="row">
                        <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Landmark</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="userlandmark"></label>
</div>
                            </div>

                        </div>

                        

                           <div class="col-xs-12 col-sm-6">

                            <div class="row">

                                <label class="col-lg-4 col-form-label">Image</label>
<div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="imgsrc"></label>
</div>
                                

                            </div>

                        </div>
                        </div>

                        


                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<!------------------------------------------>

<!-------------- Preview Modal ------------->

<!------------------------------------------>

@stop

 @section('extra_js')

 
 
 
 <script language="javascript" type="text/javascript">

    function get_role(role){

       if(role =='project_Manager' || role =='employee'){
        $('#org_hide').show();
       }else{
         $('#org_hide').hide();

       }

    }



        function validate(email) {

            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            //var address = document.getElementById[email].value;
            if (reg.test(email) == false) 
            {
               
                return (false);
            }else{

                 return (true);

            }
 }
 
 
 function valid_mobile(mobileNum){
     var validateMobNum= /^\d*(?:\.\d{1,2})?$/;
if (validateMobNum.test(mobileNum ) && mobileNum.length == 10) {
    return true;
}
else {
    return false;
}
 }


function validatePIN (pin) {
  if(pin.length === 6 ) {
    if( /[0-9]/.test(pin))  {
      return true;
    }else {return false;}
  }else {
      return false;
      }
}

</script>


    <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#orglogo").change(function(){
        readURL(this);
    });
</script>

   <script>

$(function(){$('.dateTxt').datepicker(); }); 

</script>
<script>
        function getuserValue(){
        	
      
      
            // Selecting the input element and get its value 
            var pincode = document.getElementById("pincode").value;
            var fname = document.getElementById("fname").value;
            var landmark = document.getElementById("landmark").value;
            var lname = document.getElementById("lname").value;
            var emailaddress = document.getElementById("emailaddress").value;
            var mobile = document.getElementById("mobile").value;
           
              //alert(fname);
            var uname = $('#uname').val();
         
            var role = $('#role option:selected').text();
            
           // alert(role);
         
              var alternate = $('#alternate').val();
              var pancard = $('#pancard').val();
                var adhaar = $('#adhaar').val();
                 var designation = $('#designation').val();
                  var dob = $('#dob').val();
                    var newdate = new Date(dob);
                 var dd = String(newdate.getDate()).padStart(2, '0');
                 var mm = String(newdate.getMonth() + 1).padStart(2, '0'); //January is 0!
                 var yyyy = newdate.getFullYear();

                 newdate = dd + '-' + mm + '-' + yyyy;
                  var gender = $('#gender').find(":selected").text();
                     var address = $('#address').val();
                     var empcountry = $('#empcountry').find(":selected").text();
                      var empstate = $('#empstate').find(":selected").text();
                         var city = $('#city').find(":selected").text();
                          var landmark = $('#landmark').val();
                             var img = $('#blah').attr('src');
                          
                                 var srcimg = '<img src="'+img+'" id="landmark" style="width:40px;">';
                            
                           // alert(img);
                            //alert(img);
          
               
           
            $("#userfname").html(fname);
            $("#userlname").html(lname);
            $("#useremail").html(emailaddress);
            $("#usermobile").html(mobile);
            $("#userpincode").html(pincode);
            $("#userlandmark").html(landmark);
            $('#viewrole').text(role);
            $('#username').text(uname);
              $("#altmobile").text(alternate);
              $("#pencard").text(pancard);
            $("#addhar").text(adhaar);
            $("#viewdesignation").text(designation);
          
             $("#viewdob").html(newdate);
            $("#viewgender").text(gender);
            $("#viewaddress").text(address); 
            $("#country").text(empcountry);
             $("#state").text(empstate);
             $("#viewcity").text(city);
             $("#imgsrc").html(srcimg);

             
           
           
        }


        $(document).ready(function() {
  $("#add_users").validate({
    rules: {
      fname : {
        required: true,
        minlength: 3,
        maxlength: 60,
      },
       lname : {
        required: true,
        minlength: 3,
        maxlength: 60,
      },
       role : {
        required: true,
        
      },
      mobile : {
        required: true,
        minlength: 10,
        maxlength: 10,
        number: true,
      },
        alternate : {
        
        minlength: 10,
        maxlength: 10,
        number: true,
      },
      pancard : {
        required: true,
        
        
      },
      adhaar : {
        required: true,
        number: true,
        
      },
      dob : {
        required: true,
           
      },
      gender : {
        required: true,
           
      },
      address : {
        required: true,
           
      },
       country : {
        required: true,
        
      },
       state : {
        required: true,
        
      },
       city : {
        required: true,
        
      },
       pincode : {
        required: true,
        minlength: 6
      },
       
      age: {
        required: true,
        number: true,
        min: 18
      },
      emailaddress: {
        required: true,
        email: true
      },
      alt_emailaddress: {
        
        email: true
      },
      weight: {
        required: {
          depends: function(elem) {
            return $("#age").val() > 50
          }
        },
        number: true,
        min: 0
      }
    },
    messages : {
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
      },
        lname: {
        minlength: "Last Name should be at least 3 characters",
        maxlength: "Last Name should be at Max 60 characters",
      },
      mobile: {
        minlength: "Mobile No should be at least 10 Digit"
      },
       alternate: {
        minlength: "Mobile No should be at least 10 Digit"
      },
      pincode: {
        minlength: "Pin Code should be at least 6 Digit"
      },
      age: {
        required: "Please enter your age",
        number: "Please enter your age as a numerical value",
        min: "You must be at least 18 years old"
      },
      emailaddress: {
        email: "The email should be in the format: abc@domain.tld"
      },
      alt_emailaddress: {
        email: "The email should be in the format: abc@domain.tld"
      },
      weight: {
        required: "People with age over 50 have to enter their weight",
        number: "Please enter your weight as a numerical value"
      }
    }
  });
});
    </script>


<script>
    $('#user_preview').click(function()
    {
        $('#add_users').validate();
        if ($('#add_users').valid()) // check if form is valid
        {
            $('#exampleModalScrollable').modal('show');
        }
        else 
        {
            // just show validation errors, dont post
        }
    });

</script>

  
   

   @stop

