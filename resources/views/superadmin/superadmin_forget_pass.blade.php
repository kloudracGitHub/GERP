@extends('login_layout')
   @section('content')
      <div class="login_form verify_email">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="grc_logo">
                     <a href="#"><img src="assets/images/logo.png" alt="Green ERP" title="Green ERP"></a>
                  </div>
                  <h2>Please type your Email Address for Verification</h2>
                  <form>
                     <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control custom_box" placeholder="Email" autofill="false" autocomplete="false">
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
   @stop