@extends('login_layout')
 @section('extra_css')
   <style type="text/css">
 
   </style>
   @stop

   @section('content')



  <div class="login_wrapper">

        <div class="overlay_wrapper">

            <div class="login_header">

                <div class="container-fluid">

                     <div class="col-xs-8">

                        @if(Session::has('rsuccess'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('rsuccess') }}</p>

                        @endif

                        



                        @if ($message = Session::get('war'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif

                </div>

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="login_logo">

                                <h1><a href="#"><img src="assets/images/grc_white_logo.png" alt="GRC" title="GRC"></a></h1>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="login_form">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-12">

                            <!-- <div class="grc_logo">

                                <a href="index.html"><img src="assets/images/logo.png" alt="Green ERP" title="Green ERP"></a>

                            </div> -->

                            <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/login')}}"  enctype="multipart/form-data">

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">

                                    <input type="text" name="username" id="name" class="form-control custom_box"  maxlength="60"  placeholder="Email" value="{{ old('username') }}" autofill="false" autocomplete="false">

                                @error('username')

                                                <div style="color:red; ">{{ $message }}</div>

                                                @enderror

                                </div>

                                

                                <div class="form-group">

                                    <input type="password" name="password" onkeyup="validatePassword(this.value);" id="password" maxlength="60"  class="form-control custom_box" value="{{ old('password') }}" placeholder="Password" autocomplete="false" autofill="false">

                               <div id="msg"></div>

                                @error('password')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                </div>

                                

                                <div class="form-group">

                                    <input type="submit" name="submit" class="submit_btn_cls" value="Login">

                                </div>
                              
                                @if(session::has('warning'))

                                    <p style="color:black">{{session::get('warning')}}</p>

                                    @endif

                                <div class="form-group">

                                    <div class="custom_checkbox">

                                        <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">

                                        <label for="styled-checkbox-1">Do you want to save the password</label>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="forget_link">

                                        <a href="{{URL::to('/email-verify')}}">Forget Password</a>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



            <div class="login_page_landline">

                <h2>Hand Holding Towards Sustainable Development</h2>

            </div>

        </div>
<!--<div class="modalpopup">-->
<!--    <div class="position_relative">-->
<!--        <span id="closepopup">X</span>-->
<!--    </div>-->
<!--   <h2>GRC GREEN-->
<!--</h2>-->
<!--    <div>-->
        
<!--         <h4 class="text-center">Welcome to the Launch of <strong style="font-weight: 800;color: #1B9A58;">"GreenERP"</strong> Web Portal</h4>-->
<!--        <p>-->
<!--            An Online Digital Platform for handling of Environmental Compliance-->
<!--        </p>-->
<!--        <h2 style="background: #fff;padding: 5px;"><img src="assets/images/grcfull_logo.png" class="img-fluid" alt="GRC" title="GRC">-->
<!--</h2>-->
<!--    </div>-->
<!--</div>-->
    </div>

    <a href="http://localhost/grc/public/login" rel="index,follow"></a>

<script type="text/javascript"> 

        function preventBack() { 

            window.history.forward();  

        } 

          

        setTimeout("preventBack()", 0); 

          

        window.onunload = function () { null }; 

    </script> 

  @stop


    