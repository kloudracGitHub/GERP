 @extends('superadmin_layout')

   @section('content')

 <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

               <div class="container-fluid">

                  <div class="page-title-box">

                     <div class="row align-items-center bredcrum-style">

                        <div class="col-sm-6">

                           <h4 class="page-title">View User</h4>

                        </div>

                       <!-- <div class="col-sm-6">

                           <h4 class="page-title project_super">{{$userData->project_name??''}}</h4>

                        </div>-->


               <div class="col-sm-6">

                  <h4 class="page-title project_super">   <a class="btn btn-primary" href="{{URL::to('/Profile-edit/'.$id)}}" >Edit</a>

                 @if(session('role') == 'superadmin')
 &nbsp; &nbsp;<a onclick="return confirm('Are you sure you want to delete this User?');" href="{{URL::to('/user_delele')}}/{{$id}}" class="btn btn-primary">Delete </a>  
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

                                    <tr>

                                       <th>EMP ID</th>

                                       <td>{{$userData->employee_id??''}}</td>

                                      

                                      <!--  <th>Project Name</th>

                                       <td>{{$userData->project_name??''}}</td> -->
 <th>First Name</th>

                                       <td>{{$userData->first_name??''}}

                                           <div class="user_save_wrapper" style="display: none;">

                                       <form method="POST" action="{{URL::to('/Users-view-edit/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="fname" maxlength="50">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                                                 </div>

                                       </td>
                                    </tr>

                                    <tr>

                                      

                                       <th>Last Name</th>

                                       <td>{{$userData->last_name??''}}

                                           <div class="user_save_wrapper" style="display: none;">

                                         <form method="POST" action="{{URL::to('/Users-view-edit-lname/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="lname" maxlength="50">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                                                 </div>

                                       </td>
  <th>Email Address</th>

                                       <td>{{$userData->email??''}}</td>
                                    </tr>

                                    <tr>

                                     

                                       <th>Mobile No.</th>

                                       <td>@if(!empty($userData->pre_mob)) {{$userData->pre_mob??''}}- @endif {{$userData->mobile_no??''}}

                                           <div class="user_save_wrapper" style="display: none;">

                                         <form method="POST" action="{{URL::to('/Users-view-edit-mobile/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="mobile" maxlength="10">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                                             </div>

                                       </td>
<th>Pin Code</th>

                                       <td>{{$userData->upincode??''}}

                                           <div class="user_save_wrapper" style="display: none;">

                                          <form method="POST" action="{{URL::to('/Users-view-edit-pincode/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="pincode" maxlength="6">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                                                </div>

                                       </td>
                                    </tr>

                                    <tr>

                                       

                                       <th>Landmark</th>

                                       <td>{{$userData->ulandmark??''}}

                                           <div class="user_save_wrapper" style="display: none;">

                                          <form method="POST" action="{{URL::to('/Users-view-edit-landmark/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="landmark" maxlength="110">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                                              </div>

                                       </td>
   <th>Role</th>

                                       <td>{{ucwords($userData->role??'')}}

                                    

                                       </td>
                                    </tr>

                                    

                                                      <tr>

                                    

                                       <th>Pancard No</th>

                                       <td>{{$userData->pancard_no??''}}

                                           

                                       </td>
  <th>Aadhaar Card No.</th>

                                       <td>{{$userData->adhaar_card??''}}

                                    

                                       </td>

                                    </tr>

                                    

                                    <tr>

                                     
                                       <th>Designation</th>

                                       <td>{{$userData->desgination??''}}

                                           

                                       </td>
 <th>Gender</th>

                                       <td>{{$userData->gender??''}}

                                    

                                       </td>
                                    </tr>

                                    

                                     <tr>

                                      

                                       <th>DOB</th>

                                       <td>{{date('d-M-Y', strtotime($userData->dob))}}

                                           

                                       </td>
                                        <th>Address</th>

                                       <td colspan="3">{{$userData->address??''}}

                                    

                                       </td>


                                    </tr>

                                    

                                         <!--    <tr>

                                      
                                       <th>landmark</th>

                                       <td>{{$userData->landmark}}

                                           

                                       

                                    </tr> -->

                                    

                                        <tr>

                                       <th>Country</th>

                                       <td>{{$userData->county??''}}

                                    

                                       </td>

                                       <th>State</th>

                                       <td>{{$userData->state}}

                                           

                                       </td>

                                    </tr>

                                    

                                     <tr>

                                       <th>City</th>

                                       <td>{{$userData->city??''}}

                                    

                                       </td>

                                       <th>Pin Code</th>

                                       <td>{{$userData->pincode}}

                                           

                                       </td>

                                    </tr>

                                    

                                    

                                    

                                 </table>

                              </div>

                           </div>

                         

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

         @stop