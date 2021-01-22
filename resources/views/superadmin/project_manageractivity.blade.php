@extends('login_layout')
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
                                <h1><a href="#"><img src="assets/images/grc_new_logo.png" alt="GRC" title="GRC"></a></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           Thank you for your response.
            <div class="login_page_landline">
                <h2>Hand Holding Towards Sustainable Development</h2>
            </div>
        </div>
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

    