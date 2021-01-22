  @extends('superadmin_layout')
   @section('content')
 <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                    <div class="col-xs-8">
                        @if(Session::has('change_passwordd'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('change_passwordd') }}</p>
                        @endif
                        
                        @if(Session::has('warning-cp'))
                       <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if(Session::has('warninggs'))
                       <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($message = Session::get('warning-pass'))
                        <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif
                </div>
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style">
                            <div class="col-sm-6">
                                <h4 class="page-title">Change Password</h4>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="page-title project_super"></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add_project_wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/change-password')}}"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <div class="row">

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="fname">Old Password<font color="red">*</font></label>
                                                <input name="opwd" type="password" placeholder="" class="form-control project_box" value=""  required="required">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="fname">New Password<font color="red">*</font></label>
                                                <input name="npwd" type="password" placeholder="" onkeyup="validatePassword(this.value);" class="form-control project_box" id="txtNewPassword" value="" data-minlength="8"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*-]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter and special character, and at least 8 or more characters" required="required">
                                                <div id="msg" style="color: green;"></div>
                                            
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="fname"> Confirm Password<font color="red">*</font></label>
                                                 <input name="cpwd" type="password" placeholder="" class="form-control project_box" id="txtConfirmPassword" value="" data-minlength="8"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%&*-]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter and special character, and at least 8 or more characters" required="required">
                                            </div>
                                        </div>
                                     </div>
                                       <input type="submit" name="submit" value="Submit" class="submit_btn">
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

@stop
