@extends('superadmin_layout')
@section('content')
    <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style">
                            <div class="col-sm-6">
                                <h3 class="page-title my_profile">My Profile <!-- <a href="profile_edit.html" class="edit_task">Edit</a> --></h3>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
                
                  @if(Session::has('msg'))
                        <p class="alert {{ Session::get('alert') }}"></p>
                        @endif
                        @if ($message = Session::get('msg'))
                        <div class="alert alert-{{ Session::get('alert') }} alert-block">
                          <strong>{{ $message }}</strong>
                        </div>
                        @endif
              
                <div class="add_project_wrapper after_saved_project">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="profile_save_wrapper">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-8">
                                            <ul>
                                                <li><img src="{{URL::to('uploads_profileimg/')}}/{{$userprofile->photo}}" alt="" title=""></li>
                                                <li>
                                                    <h5>{{$userprofile->first_name}}  {{$userprofile->last_name}}</h5>
                                                    <p>{{$userprofile->email}}</p>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-xs-12 col-sm-4">
                                            <div class="edit_profile_btn">
                                                <a href="{{URL::to('/Profile-edit/'.session('userId'))}}" class="edit_pro_btn">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="saved_data">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="table-responsive">
                                                <table class="table myprofile_table">
                                                    <tbody>
                                                        <tr>    
                                                            <td>EMP ID</td>
                                                            <td>{{$userprofile->employee_id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone No.</td>
                                                            <td>{{$userprofile->mobile_no}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Landmark</td>
                                                            <td>{{$userprofile->landmark}}</td>
                                                        </tr>
                                                       <!--  <tr>
                                                            <td>Marital Status</td>
                                                            <td>{{$userprofile->mobile_no}}</td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>Country</td>
                                                            <td>{{$userprofile->cname}}</td>
                                                        </tr>
                                                       <!--  <tr>
                                                            <td>Region</td>
                                                            <td></td>
                                                        </tr> -->
                                                         <tr>    
                                                            <td>State</td>
                                                            <td>{{$userprofile->sname}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="table-responsive">
                                                <table class="table myprofile_table">
                                                    <tbody>
                                                      <!--   <tr>    
                                                            <td>State</td>
                                                            <td>{{$userprofile->state}}</td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>Date of Birth</td>
                                                            <td>{{$userprofile->dob}}</td>
                                                        </tr>
                                                        <tr>    
                                                            <td>Gender</td>
                                                            <td>{{$userprofile->gender}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nationality</td>
                                                            <td>Indian</td>
                                                        </tr>
                                                        <tr>
                                                            <td>City</td>
                                                            <td>{{$userprofile->ctname}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pin Code</td>
                                                            <td>{{$userprofile->pincode}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
            <!-- content -->
        </div>
@stop