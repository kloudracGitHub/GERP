@extends('superadmin_layout')@section('content')

<div class="content-page">

   <!-- Start content -->         

   <div class="content p-0">

      <div class="container-fluid">

         <div class="page-title-box">

            <div class="row align-items-center bredcrum-style">

               <div class="col-sm-6">

                  <h4 class="page-title">View Organization</h4>

               </div>

               <div class="col-sm-6">

                  <h4 class="page-title project_super">

                     @if(session('role') == 'superadmin')

                     {{ucwords($organizationview->org_name??'')}}@if(!empty($id))   &nbsp; &nbsp;<a href="{{URL::to('/Organization-add?org=')}}{{$id??''}}" class="btn btn-primary">Edit </a> 

                     @endif

                 <!--&nbsp; &nbsp;<a  onclick="return confirm('Are you sure you want to delete this ORG and All project delete , task and User?');" href="{{URL::to('/org_delele')}}/{{$id??''}}" class="btn btn-primary">Delete </a>  -->

                     @endif

                  </h4>

               </div>

            </div>

         </div>

      </div>

      <div class="add_project_wrapper after_saved_project">

         <div class="container-fluid">

            <div class="row">

               <div class="col-xs-12 col-sm-12 col-md-12">

                  <div class="saved_data">

                     <div class="table-responsive">

                        <table class="table table-bordered">

                           @if(isset($organizationview) && !empty($organizationview))                                         

                           <tr>

                              <th>Organization Name</th>

                              <td>

                                 <p class="saved_details">{{$organizationview->org_name??''}}  </p>

                                 <div class="user_save_wrapper" style="display: none;">

                                    <form method="POST" action="{{URL::to('Organization-view-editorggg/'.$organizationview->orgid??'')}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                          <input type="text" class="form-control select_user_inside" name="org" maxlength="60">                                                       <input type="submit" name="submit" value="Save" id="saveUser" class="save_user">                                                      </form>

                                 </div>

                                 <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span>                                             

                              </td>

                              <th>Organization Email</th>

                              <td>{{$organizationview->org_email??''}}</td>

                           </tr>

                           <tr>

                              <!-- <th>User Name</th>                                             <td>                                             <p class="saved_details">{{$organizationview->user_name}}</p>                                             <div class="user_save_wrapper" style="display: none;">                                                      <form method="POST" action="{{URL::to('Organization-view-editorgggUser/'.$organizationview->orgid)}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                              <input type="text" class="form-control select_user_inside" name="username">                                                         <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">                                                     </form>                                                 </div>                                                  <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span></td> -->                                                                                      

                           </tr>

                           <tr>

                              <th>Alternate No.</th>

                              <td>

                                 <p class="saved_details">{{$organizationview->altno??''}} </p>

                                 <div class="user_save_wrapper" style="display: none;">

                                    <form method="POST" action="{{URL::to('Organization-view-editorgggalternate/'.$organizationview->orgid)}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                         <input type="text" class="form-control select_user_inside" name="alternate" maxlength="20">                                                         <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">                                                     </form>

                                 </div>

                                 <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span>

                              </td>

                              <th>Country</th>

                              <td>{{$organizationview->countryname??''}}</td>

                           </tr>

                           <tr>

                              <th>State</th>

                              <td>{{$organizationview->statename??''}}</td>

                              <th>City</th>

                              <td>{{$organizationview->cityname??''}}</td>

                           </tr>

                           <tr>

                              <th>Pin Code</th>

                              <td>

                                 <p class="saved_details">{{$organizationview->orgpincode??''}} </p>

                                 <div class="user_save_wrapper" style="display: none;">

                                    <form method="POST" action="{{URL::to('Organization-view-editorgggpincode/'.$organizationview->orgid??'')}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                             <input type="number" class="form-control select_user_inside" name="pincode" maxlength="10">                                                         <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">                                                     </form>

                                 </div>

                                 <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span>

                              </td>

                              <th>Address</th>

                              <td>

                                 <p class="saved_details">{{$organizationview->org_address??''}} </p>

                                 <div class="user_save_wrapper" style="display: none;">

                                    <form method="POST" action="{{URL::to('Organization-view-editorgggaddress/'.$organizationview->orgid??'')}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                             <input type="text" class="form-control select_user_inside" name="address">                                                         <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">                                                     </form>

                                 </div>

                                 <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span>                                             

                              </td>

                           </tr>

                           <tr>

                              <th>Organization Status</th>

                              <td>

                                 <?php if(($organizationview->org_status) ==1){                                                     $value = 'Active';                                                 }else{                                                     $value = 'Inactive';                                                 }?>                                              

                                 <p class="saved_details">                                                 {{$value}} </p>

                              </td>

                              <th>Admin Name</th>

                              <td>{{$organizationview->first_name}}  {{$organizationview->middle_name}} {{$organizationview->last_name}}</td>

                           </tr>

                           <tr>

                              <th>Mobile No</th>

                              <td>

                                 <p class="saved_details">{{$organizationview->org_mobile}} </p>

                                 <div class="user_save_wrapper" style="display: none;">

                                    <form method="POST" action="{{URL::to('Organization-view-editorgggmobile/'.$organizationview->orgid)}}">                                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                           <input type="text" class="form-control select_user_inside" name="mobile" maxlength="10">                                                         <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">                                                     </form>

                                 </div>

                                 <span class="edit_icon">                                                     <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">                                                 </span>

                              </td>

                              <th>Logo</th>

                              <td>

                                 <p>                                                 @if(!empty($organizationview->logo))<img src="{{ asset('org_uploads/'.$organizationview->logo) }}" width="67px">  @else  <img src="{{ asset('uploads/org.png') }}" width="67px">  @endif</p>

                              </td>

                           </tr>

                  <!--          <tr>

                              <th>Admin Name</th>

                              <td colspan="6"> {{$organizationview->first_name}}  {{$organizationview->middle_name}} {{$organizationview->last_name}}</td>

                           </tr> -->

                           @else                                                                                  Organization Not Found                                                                                  @endif                                                                              

                        </table>

                     </div>

                     <div class="col-sm-12 text-center">

                        <a href="javascript: history.go(-1)" class="btn btn-primary">Back</a>                                 

                     </div>

                  </div>

               </div>

            </div>

            <!-- end row -->                 

         </div>

      </div>

      <!-- container-fluid -->         

   </div>

   <!-- content -->         <!-- <footer class="footer">© 2019 GRC </footer> -->     

</div>

<!-- ============================================================== -->     <!-- End Right content here -->     @stop

