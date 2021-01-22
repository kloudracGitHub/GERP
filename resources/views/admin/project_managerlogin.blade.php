@extends('login_layout')
   @section('content')
      <div class="login_form">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="grc_logo">
                     <a href="#"><img src="assets/images/logo.png" alt="Green ERP" title="Green ERP"></a>
                  </div>
                     <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/projectmanager_login')}}"  enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                     <div class="form-group">
                        <input type="email" name="username" id="name" class="form-control custom_box" placeholder="Username" autofill="false" autocomplete="false">
                        
                     </div>
                     <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control custom_box" placeholder="Password" autocomplete="false" autofill="false">
                     </div>
                     <div class="form-group">
                        <input type="submit" name="submit" class="submit_btn_cls" value="Login">
                     </div>
                     
                     <div class="form-group">
                        <div class="custom_checkbox">
                           <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="1" name="remember">
                           <label for="styled-checkbox-1">Do you want to save the password?</label>
                        </div>
                     </div>
                   <!--   <div class="form-group">
                        <div class="forget_link">
                           <a href="javascript:void(0);">Forget Password?</a>
                        </div>
                     </div> -->
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
  @stop