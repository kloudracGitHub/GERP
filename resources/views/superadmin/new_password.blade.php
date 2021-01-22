 @extends('login_layout')
   @section('content')
    <div class="login_wrapper forget_pass_wrapper">
        <div class="overlay_wrapper">
            <div class="login_header">
                <div class="container-fluid">
                                        <div class="col-xs-8">
                       
                        @if ($message = Session::get('warning'))
                        <div class="alert alert-danger alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif
                </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="login_logo">
                                <h1><a href="#"><img src="assets/images/grc_new_logo.png" alt="GRC" title="GRC"></a></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login_form verify_email">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="grc_logo">
                                <!-- <a href="index.html"><img src="assets/images/logo.png" alt="Green ERP" title="Green ERP"></a> -->
                            </div>
                              <form  class="form-horizontal" role="form" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="new_password">
                                        <h3>Type New Password</h3>
                                        <input type="password" name="newpassword" id="newpassword" class="form-control custom_box" placeholder="Password" autofill="false" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="new_password">
                                        <h3>Confirm Password</h3>
                                        <input type="password" name="repeatpassword" id="repeatpassword" class="form-control custom_box" placeholder="Password" autofill="false" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="submit_btn_cls" value="Save Password">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop