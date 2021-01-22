 @extends('login_layout')
   @section('content')
 <div class="login_wrapper forget_pass_wrapper">
        <div class="overlay_wrapper">
            <div class="login_header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="login_logo">
                                <h1><a href="#"><img src="assets/images/grc_white_logo.png" alt="GRC" title="GRC"></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login_form verify_email">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <div class="grc_logo">
                                <a href="#"><img src="assets/images/logo.png" alt="Green ERP" title="Green ERP"></a>
                            </div> -->
                            <h2>Please type your Email Address for Verification</h2>
                              <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/email-verify')}}"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control custom_box" placeholder="Email" maxlenght="60" autofill="false" autocomplete="false">
                                    @if(session::has('warning'))
                                    <p style="color:red">{{session::get('warning')}}</p>
                                    @endif
                                     @if(session::has('alert-success'))
                                    <p style="color:green">{{session::get('alert-success')}}</p>
                                    @endif
                                     @error('email')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="submit_btn_cls" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop