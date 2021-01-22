 @extends('superadmin_layout')
   @section('content')

   <?php

if(!empty($edit_org)){

    $name = 'Edit';

}else{

     $name = 'Add';

}

   ?>

    <?php $con_list = DB::table('grc_superadmin_country_list')->join('alm_countries','grc_superadmin_country_list.country_id','=','alm_countries.id')->

                                            get();?>


            <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style">
                            <div class="col-sm-6">
                                <h4 class="page-title">{{$name}} Organization  </h4>
                            </div>
                            <div class="col-sm-6">
                               <!--  <h4 class="page-title project_super">Supertech</h4> -->
                            </div>
                        </div>
                    </div>
                </div>
                
             

                <div class="add_project_wrapper add_org_wrapper">
                    
                    <div class="container-fluid">
                        <div class="col-xs-8">
                        @if(Session::has('org-success'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('org-success') }}</p>
                        @endif
                        
                        @if ($message = Session::get('warning-org'))
                        <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('required-org'))
                        <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if(Session::has('msg'))
                        <p class="alert {{ Session::get('alert') }}"></p>
                        @endif
                        @if ($message = Session::get('msg'))
                        <div class="alert alert-{{ Session::get('alert') }} alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif
                </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <form class="court-info-form" id="add_org"  role="form" method="POST" action="{{URL::to('/Organization-add')}}"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgname">Organization Name</label><span style="color:red;">*</span>
                                                <input type="text" name="orgname" id="orgname" maxlenght="60" class="form-control project_box"   @if(!empty($edit_org)) value="{{$edit_org->org_name}}" @else  value="{{ old('orgname') }}"  @endif>
                                               <div id="orgname_error"></div>
                                                @error('orgname')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgemail">Organization Email</label><span style="color:red;">*</span>
                                                <input type="email" name="org_email" id="org_email"   class="form-control project_box"   @if(!empty($edit_org)) value="{{$edit_org->org_email}}" @else  value="{{ old('org_email') }}"  @endif>
                                                
                                                <div id="org_email_error"></div>
                                                 @error('org_email')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                       <!--  <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="uname">User Name</label>
                                                <input type="text" name="uname" id="uname" class="form-control project_box" autofill="false">
                                            </div>
                                        </div> -->
                                        <?php  $adminname = DB::table('grc_user')->where('role','admin')->where('status', 1)->get(); ?>

                                        @if(empty($edit_org))  
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="uname">Admin Name</label><span style="color:red;">*</span>
                                                <select name="adminname" id="adminname" class="form-control project_box" autofill="false">
                                                    <option value="">Select Option</option>
                                                    @foreach($adminname as $admin)
                                                    @if(empty($admin->org_id))
                                                    <option value="{{$admin->id}}"  >{{$admin->first_name}} {{$admin->last_name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                 <div id="adminname_error"></div>
                                                 @error('adminname')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                               
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <!--<div class="col-xs-12 col-sm-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label for="upassword">Password</label><span style="color:red;">*</span>-->
                                        <!--        <input type="password" name="upassword" id="txtNewPassword" class="form-control project_box" autofill="false">-->
                                        <!--         @error('upassword')-->
                                        <!--        <div style="color:red;">{{ $message }}</div>-->
                                        <!--        @enderror-->
                                        <!--    </div>-->
                                        <!--</div>-->

                                        <!--<div class="col-xs-12 col-sm-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label for="confirmpassword">Confirm Password</label><span style="color:red;">*</span>-->
                                        <!--        <input type="password" name="confirmpassword" id="txtConfirmPassword" onChange="checkPasswordMatch();" class="form-control project_box">-->
                                        <!--    </div>-->
                                        <!--     <div class="registrationFormAlert" id="divCheckPasswordMatch">-->
                                        <!--         @error('confirmpassword')-->
                                        <!--        <div style="color:red;">{{ $message }}</div>-->
                                        <!--        @enderror-->
                                        <!--</div>-->
                                        <!--</div>-->
                                       

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgmobile">Mobile No.</label><span style="color:red;">*</span>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <select class="form-control project_box" name="pre_mob">
                                                            @foreach($con_list as $con_lists)
                                                            <option value="{{$con_lists->phonecode}}" @if(!empty($edit_org)) @if($edit_org->pre_mob == $con_lists->phonecode) selected  @endif @endif>+{{$con_lists->phonecode}}</option>
                                                             @endforeach
                                                        </select>
                                                    </div>
                                                      <div class="col-sm-8">
                                                           <input type="text" onkeypress="preventNonNumericalInput(event)"  name="org_mobile" id="org_mobile" class="form-control project_box"   minlength="10" maxlength="10"  @if(!empty($edit_org)) value="{{$edit_org->mobile_no}}" @else  value="{{ old('org_mobile') }}"  @endif>
                                                <div id="org_mobile_error"></div>
                                                 @error('org_mobile')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                                          </div>
                                                </div>
                                               
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgphone">Phone No.</label>
                                                <input type="text" name="orgphone" id="orgphone" class="form-control project_box" title="Format: 0000-000-0000" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}">
                                            </div>
                                        </div> -->

                                        <!--<div class="col-xs-12 col-sm-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label for="orgalterno">Alternate No.</label>-->
                                        <!--          <div class="row">-->
                                        <!--            <div class="col-sm-4">-->
                                        <!--                                                                                                                         <input type="text"  minlength="10" maxlength="10" class="form-control project_box">-->
                                        <!--            </div>-->
                                        <!--              <div class="col-sm-8">-->
                                        <!--                                                                 <input type="text" onkeypress="preventNonNumericalInput(event)" name="orgalterno" id="orgalterno"  minlength="10" maxlength="10" class="form-control project_box"  @if(!empty($edit_org)) value="{{$edit_org->alternate_no}}" @else  value="{{ old('orgorgalterno_mobile') }}"  @endif>-->
                                        <!--                  </div>-->
                                        <!--        </div>-->
                                                 
                                                 
                                        <!--         @error('orgalterno')-->
                                        <!--        <div style="color:red;">{{ $message }}</div>-->
                                        <!--        @enderror-->
                                        <!--    </div>-->
                                        <!--</div>-->

                                       
                                
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgcountry">Country</label><span style="color:red;">*</span>
     
                                              <select name="orgcountry" id="orgcountry" class="form-control project_box">
                                                    <option value="">Please Select</option>
                                                    @foreach($CData as $result)
                                                    <option value="{{$result['countryid']}}"  @if(!empty($edit_org)) @if($edit_org->country == $result['countryid']) selected  @endif @endif>{{$result['countryname']}}</option>
                                                    @endforeach
                                                </select>
                                                <div id="orgcountry_error"></div>
                                                 @error('orgcountry')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                       
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgstate">State</label><span style="color:red;">*</span>
                                                <select name="orgstate" id="orgstate" class="form-control project_box statelist">
                                                    <option value="">Please Select</option>
                                                    @if(!empty($edit_org))

                                                     <?php
                                       $state = DB::table('alm_states')->where('country_id',$edit_org->country)->get();

                                        ?>
                                                    @foreach($state  as $states)
                                                      <option value="{{$states->id}}" @if($edit_org->state == $states->id) selected  @endif>{{$states->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                 <div id="orgstate_error"></div>
                                                 @error('orgstate')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                   
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgcity">City</label><span style="color:red;">*</span>

                                                <SELECT name="orgcity" id="orgcity" class="form-control project_box citylist">
                                                    <option value="">Please Select</option>
                                                    

                                                   @if(!empty($edit_org))

                                                     <?php
                                       $city = DB::table('alm_cities')->where('state_id',$edit_org->state)->get();

                                        ?>
                                                    @foreach($city  as $citys)
                                                      <option value="{{$citys->id}}" @if($edit_org->city == $citys->id) selected  @endif>{{$citys->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <div id="orgcity_error"></div>
                                                </SELECT>
                                                 @error('orgcity')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                               
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgcity">Pin Code <span style="color:red;">*</span></label>
                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="orgpincode" id="orgpincode" class="form-control project_box"  maxlength="6"  @if(!empty($edit_org)) value="{{$edit_org->pincode}}" @else  value="{{ old('orgpincode') }}"  @endif>
                                                 <div id="orgpincode_error"></div>
                                                 @error('orgpincode')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                              

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orgaddress">Address</label><span style="color:red;">*</span>
                                                <textarea rows="4" name="orgaddress" id="orgaddress" maxlenght="255" class="form-control project_box">@if(!empty($edit_org)) {{$edit_org->address}} @else  {{ old('orgaddress') }}  @endif</textarea>
                                            </div>
                                            <div id="orgaddress_error"></div>
                                             @error('orgaddress')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                        </div>
                                         
                                          <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="orglogo">Logo</label> 
                                                <input type="file" name="orglogo"  class="form-control project_box file_input" onchange="return ValidateFileUpload()" id="fileChooser">

                                                 @if(!empty($edit_org)) 
                                                <input type="hidden" name="org_id" value="{{$edit_org->id}}">
                                     
                                                    @endif

                                                @if(!empty($edit_org)) 
                                                 <img src="{{URL::to('/org_uploads/')}}/{{$edit_org->logo}}" id="blah" width="67px" >
                                                  @else  
                                                   <img src="" id="blah" width="67px"> 
                                                    @endif

                                             <div id="fileChooser_error"></div>
                                             @error('orglogo')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6"></div>

                                        <div class="col-xs-12 col-sm-12 text-center">
                                                <button type="button"  class="previvew_btn preview" id="sameasdata" onclick="getInputValue();">Preview</button>
                                                <!--<input type="submit" name="submit" value="Submit" onclick="submitDetailsForm()" class="submit_btn">-->
                                                 <button type="submit"  class="submit_btn ">Submit</button>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6">
                                            <div class="see_details">
                                                <p>Click <a href="org_details.html">here</a> to see project details.</p>
                                            </div>
                                        </div> -->
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
    <div id="addproject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Create a New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="example-text-input1" class="col-sm-4 col-form-label">Organization Name</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" id="example-text-input2">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-text-input3" class="col-sm-4 col-form-label">Project ID</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" id="example-text-input4">
                    </div>

                </div>
                <div class="form-group row">
                    <label for="example-text-input5" class="col-sm-4 col-form-label">Project Type</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" id="example-text-input6">
                    </div>

                </div>

                <div class="form-group row">
                    <label for="example-text-input7" class="col-sm-4 col-form-label">Organization ID</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="Artisanal kale" id="example-text-input8">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input9" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" value="" id="example-text-input10">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-text-input11" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="mail" value="" id="example-text-input12">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect">Create Project</button>
                <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal-content -->

<!------------------------------------------>
<!-------------- Preview Modal ------------->
<!------------------------------------------>
<div class="modal fade bd-example-modal-lg preview_form" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0 header_color" id="myModalLabel">Organization Preview</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--    <span aria-hidden="true">&times;</span>-->
                <!--</button>-->
            </div>
            <div class="modal-body">
                <div class="preview_mode">
                    <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Organization Name</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="previeworgname" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                              <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Organization Email</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="previeworgemail" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                       </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Mobile No.</label>
                                 <div class="col-lg-8 col-form-label">
                                <label id='previeworgmobile' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>Phone No.</label>
                                <p id='previeworgphone'></p>
                            </div>
                        </div> -->
                        <!--<div class="col-xs-12 col-sm-6">-->
                        <!--    <div class="row">-->
                        <!--        <label class="col-lg-4 col-form-label">Alternate No.</label>-->
                        <!--         <div class="col-lg-8 col-form-label">-->
                        <!--        <label id='previeworgaltno' class="myprofile_label m-0">N/A</label>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                          <div class="col-xs-12 col-sm-6">
                            <div class="row">
                               
                                <label class="col-lg-4 col-form-label">Country</label>
                                 <div class="col-lg-8 col-form-label">
                                <label id='previeworgcountry' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                          <div class="row b-b">
                      
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">State</label>
                                 <div class="col-lg-8 col-form-label">
                                <label id='previeworgstate' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                          <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">City</label>
                                  <div class="col-lg-8 col-form-label">
                                <label id='previeworgcity' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                          <div class="row b-b">
                      
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Pin Code</label>
                                  <div class="col-lg-8 col-form-label">
                                <label id='previeworgpincode' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                          <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Admin Name</label>
                                  <div class="col-lg-8 col-form-label">
                                <label id='previewadminname' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                         </div>
                             <div class="row">
                           <div class="col-xs-12 col-sm-12">
                            <div class="row">
                                <label class="col-lg-2 col-form-label">Address</label>
                                 <div class="col-lg-10 col-form-label">
                                <label id='previeworguname' class="myprofile_label m-0">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                       
                       <!--  <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>Status</label>
                                <p id='previeworgstatus'></p>
                            </div>
                        </div> -->
                        <!-- <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label>Logo</label>
                                <p id='previeworglogo'><img src="assets/images/logo.png" alt="" title=""></p>
                            </div>
                        </div> -->
                       <!--  <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label>Project Description</label>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div> -->
                   
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
</div>
<!-- /.modal-dialog -->
</div>
@stop


@section('extra_js')

 <script language="javascript" type="text/javascript">
 
 

 
 
 
 
//     function submitDetailsForm() {
        
//         var result = confirm("Are Sure Create ORG?");
// if (result) {
    
//         $("#add_org").submit();
// }
 
//     }
</script>
<script>


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

        function getInputValue(){
      //       var orgname = $('#orgname').val();
      //   var org_email = $('#org_email').val();
      //   var adminname = $('#adminname').val();
      //   var org_mobile = $('#org_mobile').val();
      //   var orgcountry = $('#orgcountry').val();
      //   var orgstate = $('#orgstate').val();
      //   var orgcity = $('#orgcity').val();
      //   var orgpincode = $('#orgpincode').val();
      //   var orgaddress = $('#orgaddress').val();
      //    var fileChooser = $('#fileChooser').val();
         
      //       if(orgname ==''){
      //    $('#orgname_error').text('ORG Name is Required').attr('style','color:red');
      //    $('#orgname_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgname_error').hide();  error = 1;}
      
      //    if(org_email ==''){
      //    $('#org_email_error').text('Email is Required').attr('style','color:red');
      //    $('#org_email_error').show();
      //      error = 0;
      //         return false;
              
      //    }else if(validate(org_email) == false){
      //    $('#org_email_error').text('Enter valid Email').attr('style','color:red');
      //    $('#org_email_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#org_email_error').hide();  error = 1;}
      
      //  if(adminname ==''){
      //    $('#adminname_error').text('Admin Name is Required').attr('style','color:red');
      //    $('#adminname_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#adminname_error').hide();  error = 1;}
      
      //  if(org_mobile ==''){
      //    $('#org_mobile_error').text('Mobile is Required').attr('style','color:red');
      //    $('#org_mobile_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#org_mobile_error').hide();  error = 1;}
      
      //  if(orgcountry ==''){
      //    $('#orgcountry_error').text('Country is Required').attr('style','color:red');
      //    $('#orgcountry_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgcountry_error').hide();  error = 1;}
      
      //  if(orgstate ==''){
      //    $('#orgstate_error').text('State is Required').attr('style','color:red');
      //    $('#orgstate_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgstate_error').hide();  error = 1;}
      
      //  if(orgcity ==''){
      //    $('#orgcity_error').text('City is Required').attr('style','color:red');
      //    $('#orgcity_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgcity_error').hide();  error = 1;}
      
      
      // if(orgpincode ==''){
      //    $('#orgpincode_error').text('Pin Code is Required').attr('style','color:red');
      //    $('#orgpincode_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgpincode_error').hide();  error = 1;}
      
      // if(orgaddress.length ==0){
      //    $('#orgaddress_error').text('Address is Required').attr('style','color:red');
      //    $('#orgaddress_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#orgaddress_error').hide();  error = 1;}
      // @if(empty($edit_org))
      // if(fileChooser ==''){
      //    $('#fileChooser_error').text('File is Required').attr('style','color:red');
      //    $('#fileChooser_error').show();
      //      error = 0;
      //         return false;
      // }else{$('#fileChooser_error').hide();  error = 1;}
      // @endif
           
            // Selecting the input element and get its value 
            var orgname = document.getElementById("orgname").value;
            var orgemail = document.getElementById("org_email").value;
              var adminname =$("#adminname option:selected").text() ;
           var orgaddress = document.getElementById("orgaddress").value;
            var orgmobile = document.getElementById("org_mobile").value;
            // var orgalterno = document.getElementById("orgalterno").value;
            var orgcountry = $("#orgcountry option:selected").text();
            var orgstate = $("#orgstate option:selected").text();
            var orgcity = $("#orgcity option:selected").text();
            var orgpincode = document.getElementById("orgpincode").value;
            $("#previeworgname").html(orgname);
            $("#previeworgemail").html(orgemail);
            $("#previeworguname").html(orgaddress);
            $("#previeworgmobile").html(orgmobile);
            // $("#previeworgaltno").html(orgalterno);
            $("#previeworgcountry").html(orgcountry);
            $("#previeworgstate").html(orgstate);
            $("#previeworgcity").html(orgcity);
            $("#previeworgpincode").html(orgpincode);
            $("#previewadminname").html(adminname);
          //  $('#exampleModalScrollable').modal('show');
        
           
        }
        $(document).ready(function() {
  $("#add_org").validate({
    rules: {
      orgname : {
        required: true,
        minlength: 3,
        maxlength: 60,
      },
       adminname : {
        required: true,
        
      },
      org_mobile : {
        required: true,
        minlength: 10,
        maxlength: 10,
        number: true,
      },
       orgcountry : {
        required: true,
        
      },
       orgstate : {
        required: true,
        
      },
       orgcity : {
        required: true,
        
      },
       orgpincode : {
        required: true,
        minlength: 6
      },
       orgaddress : {
        required: true,
        
      },
      age: {
        required: true,
        number: true,
        min: 18
      },
      org_email: {
        required: true,
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
      orgname: {
        minlength: "Name should be at least 3 characters",
        maxlength: "Name should be at Max 60 characters",
      },
      org_mobile: {
        minlength: "Mobile No should be at least 10 Digit"
      },
      orgpincode: {
        minlength: "Pin Code should be at least 6 Digit"
      },
      age: {
        required: "Please enter your age",
        number: "Please enter your age as a numerical value",
        min: "You must be at least 18 years old"
      },
      org_email: {
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
    $('#sameasdata').click(function()
    {
        $('#add_org').validate();
        if ($('#add_org').valid()) // check if form is valid
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