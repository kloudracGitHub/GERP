@extends('superadmin_layout')

@section('content')

<div class="content-page">

   <!-- Start content -->

   <div class="content p-0">

      <div class="container-fluid">

         <div class="page-title-box">

            <div class="row align-items-center bredcrum-style">

               <div class="col-sm-6">

                  <h4 class="page-title">View Project</h4>

               </div>

               <div class="col-sm-6">

                  <h4 class="page-title project_super">{{ucwords($projectview->project_name??'')}}   <a class="btn btn-primary" href="{{URL::to('/Project-edit/'.$id)}}" >Edit</a>

                 @if(session('role') == 'superadmin')
 &nbsp; &nbsp;<a onclick="return confirm('Are you sure you want to delete this Project?');" href="{{URL::to('/pro_delele')}}/{{$id}}" class="btn btn-primary">Delete </a>  
 @endif
                  </h4>
                 
               </div>

            </div>

         </div>

      </div>

      

       @if(session::has('msg'))

                <div class="alert alert-warning alert-dismissible fade show" role="alert">

              {{session::get('msg')}}

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">

    <span aria-hidden="true">&times;</span>

  </button>

</div>

                @endif

      <div class="add_project_wrapper after_saved_project">

         <div class="container-fluid">

            <div class="row">

               <div class="col-xs-12 col-sm-12 col-md-12">

                  <div class="saved_data">

                     <div class="table-responsive">

                        <table class="table table-bordered">

                           <tr>

                              <th>Project Name</th>

                              <td>{{$projectview->project_name??''}}

                                   <div class="user_save_wrapper" style="display: none;">

                                                       <form method="POST" action="{{URL::to('/Project-view-editprojectname/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="projectname">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                              </td>

                              <th>Organization Name</th>

                              <td>{{$projectview->org_name??''}}</td>

                           </tr>

                           <tr>

                              <th>Project Type</th>

                              <td>{{$projectview->project_type??''}}</td>

                              <th>Type Of NOC</th>

                              <td>{{$projectview->project_stage??''}}</td>

                           </tr>

                           <tr>

                              <th>Pin Code</th>

                              <td>{{$projectview->propincode??''}}

                                 <div class="user_save_wrapper" style="display: none;">

                                                      <form method="POST" action="{{URL::to('/Project-view-editpincode/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="pincode">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                              </td>

                              <th>Landmark</th>

                              <td>{{$projectview->landmark??''}}

                               <div class="user_save_wrapper" style="display: none;">

                                                       <form method="POST" action="{{URL::to('/Project-view-editlandmark/'.$id)}}">

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">    

                                                            <input type="text" class="form-control select_user_inside" name="landmark">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>



                                                    </div>

                                                     <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                              </td>

                           </tr>

                           <tr>

                              <th>Sector</th>

                              <td>{{$projectview->sector_name??''}}</td>

                              <th>State</th>

                              <td>{{$projectview->statename??''}}</td>

                           </tr>

                           <tr>

                              <th>City</th>

                              <td>{{$projectview->cityname??''}}</td>

                              <th>Currency</th>

                              <td>{{$projectview->currencycode??''}}</td>

                           </tr>

                           <tr>

                              <th>Project Status</th>

                              <td>{{$projectview->project_status??''}}</td>

                              <th>Project Manager</th>

                              <td>{{$projectview->first_name}} {{$projectview->middle_name}} {{$projectview->last_name}}</td>

                           </tr>
                           
                             <tr>

                              <th>Letter No</th>

                              <td>{{$projectview->letter_no??''}}</td>

                              <th>Project Category</th>

                              <td>{{$projectview->cat}} </td>

                           </tr>
                           
                           <tr>

                          

                              <th>Start Date</th>

                              <td>{{$projectview->start_date}} </td>
                              
                              <th>End Date</th>

                              <td>{{$projectview->end_date}} </td>

                           </tr>
                           
                            

                              <th>Project Estimated Hours</th>

                              <td>{{$projectview->estimated_hrs??''}}</td>

                              <th>Description</th>

                              <td>{{$projectview->description}} </td>
                              
                              
                             
                           </tr>
                                  <tr>

                                <th>Project Location</th>

                              <td>{{$projectview->project_alias}} </td>
                              </tr>
                              


                        </table>

                     </div>

                  </div>

                  <div class="row">

                     <div class="col-xs-12 col-sm-12">

                        <div class="form-group">

                           <label for="prDescription">Project Description</label>

                           <p>{{$projectview->prodescription??''}}</p>

                            <div class="user_save_wrapper" style="display: none;">

                                                      

                                                      <div class="user_save_wrapper" style="display: none;">

                                                         <form method="POST" action="{{URL::to('Organization-view-editorggg/')}}">  

                                                         <input type="hidden" name="_token" value="{{ csrf_token() }}">   

                                                            <input type="text" class="form-control select_user_inside" name="projectname">

                                                            <input type="submit" name="saveUser" value="Save" id="saveUser" class="save_user">

                                                        </form>

                                                    </div>

                                                    <span class="edit_icon">

                                                        <img src="{{URL::to('assets/images/edit_icon.png')}}" alt="" title="">

                                                    </span>

                        </div>

                     </div>

                  </div>



                    <div class="col-xs-12 col-sm-12">

                      <div class="col-xs-8">

                        @if(Session::has('alert-currency'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert-currency') }}</p>

                        @endif



                        @if(Session::has('doc-deleted'))

                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('doc-deleted') }}</p>

                        @endif

                        

                        @if ($message = Session::get('docnot'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif



                        @if ($message = Session::get('warn-doc'))

                        <div class="alert alert-danger alert-block">

                          <strong>{{ $message }}</strong>

                        </div>

                        @endif

                     </div>

                           <form class="court-info-form" id="attachment" role="form" method="POST" action="{{URL::to('/Project-document/'.$projectview->proid)}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              <div class="common_attachment_section org_attachment_add">

                                 <div class="attachment_heading">

                                    <h2>

                                       <a data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" class="collapsed">

                                       Attachment

                                       <span class="plus_icon">    

                                       <i class="fas fa-plus"></i>

                                       </span>

                                       <span class="minus_icon">

                                       <i class="fas fa-minus"></i>

                                       </span>

                                       </a>

                                    </h2>

                                 </div>

                                 <div class="upload_doc_inner">

                                    <div class="collapse multi-collapse  @if(session::has('warn-doc')) show @endif @error('task_upload') show @enderror" id="multiCollapseExample1">

                                       <div class="card card-body task_history_details">

                                          <div class="row">

                                             <div class="col-xs-12 col-sm-6 right_border">

                                                <div class="row">

                                                   <div class="col-xs-12 col-sm-4">

                                                      <div class="form-group">

                                                         <label for="selectcatefory">Type Of Document</label>

                                                      </div>

                                                   </div>

                                                   <?php

                                      $form = [1 => 'Form 1', 2 => 'Form 1A', 3 => 'Conceptual Plan' , 4 => 'EIA' , 5 => 'PFR'];
                                                   ?>

                                                   <div class="col-xs-12 col-sm-8">

                                                      <div class="form-group">

                                                         <select class="form-control" id="selectcatefory" name="selectcatefory">

                                                            <option value="">Select Category</option>
                                                           @foreach($form as $key => $forms)
                                                            <option value="{{$key}}">{{$forms}}</option>
                                                            @endforeach

                                                            

                                                         </select>

                                                            @error('selectcatefory')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                                      </div>

                                                   </div>

                                                   <div class="col-xs-12 col-sm-12">

                                                      <div class="task_upload_wrapper">

                                                         <div class="uploading_task">

                                                            <img src="{{URL::to('assets/images/uploa_icon.png')}}" alt="" title="">

                                                            <input id="file-upload" type="file" name="task_upload">
                                                            <label id="file-name"></label>
                                                         </div>

                                                          @error('task_upload')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                                         <p class="m-t-40">Accept Max 50 MB, and file Accepted PNG,JPG, GIF DOC, PDF</p>

                                                         <div class="inline_form m-t-20">

                                                            <!--<input type="text" name="browsefiles" class="browse_file" id="browsefiles" placeholder="Browse Files">-->

                                                            <input type="submit" name="upload" class="submit_btn" value="Upload">

                                                         </div>

                                                         <!-- <input type="" name=""> -->

                                                      </div>

                                                   </div>

                                                </div>

                                             </div>

                                             <div class="col-xs-12 col-sm-6">

                                                <div class="uploaded_line_item">

                                                   <div class="inside_collapse">

                                                      <div class="accordion" id="accordionExample">


                                                       @foreach($form as $key => $forms)
                                                         
                                                         <div class="card">

                                                            <div class="card-header" id="heading_{{$key}}">

                                                               <h2 class="mb-0">

                                                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse__{{$key}}" aria-expanded="false" aria-controls="collapse__{{$key}}">

                                                                  {{$forms}}

                                                                  <span class="plus_icon">

                                                                  <i class="fas fa-plus"></i>

                                                                  </span>

                                                                  <span class="minus_icon">

                                                                  <i class="fas fa-minus"></i>

                                                                  </span>

                                                                  </button>

                                                               </h2>

                                                            </div>

                                                            <div id="collapse__{{$key}}" class="collapse" aria-labelledby="heading_{{$key}}" data-parent="#accordionExample">

                                                              <?php   $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category',$key)->get();

                                                             // echo "<pre>"; print_r($projectdoc); die('dcd');  

                                                               

                                                              ?>

                                                               <div class="card-body uploaded_item_list">

                                                                  <div class="inner_body">
                                                                      <ol>
                                                                       @foreach($projectdoc as $value)

                                                                        <li>

                                                                          {{$value->document}} <a style="padding: 0 5px;color:#007bff" href="{{URL::to('uploads/'.$value->document)}}" download>Download
                                                                          <a onclick="return confirm('Are you sure you want to delete?');" href="{{URL::to('project-doc-delete/'.$value->id)}}"><i class="fas fa-times close_doc"></i></a>
                                                                          </li>

                                                                        @endforeach
</ol>
                                                                  </div>

                                                               </div>

                                                            </div>

                                                         </div>

                                                         @endforeach

<!-- 
                                                         <div class="card">

                                                            <div class="card-header" id="headingOne">

                                                               <h2 class="mb-0">

                                                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">

                                                                  Form 1

                                                                  <span class="plus_icon">

                                                                  <i class="fas fa-plus"></i>

                                                                  </span>

                                                                  <span class="minus_icon">

                                                                  <i class="fas fa-minus"></i>

                                                                  </span>

                                                                  </button>

                                                               </h2>

                                                            </div>

                                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">

                                                              <?php   $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category','Form1')->get();

                                                             // echo "<pre>"; print_r($projectdoc); die('dcd');  

                                                               

                                                              ?>

                                                               <div class="card-body uploaded_item_list">

                                                                  <div class="inner_body">

                                                                     <ol>

                                                                       @foreach($projectdoc as $value)

                                                                        <li>

                                                                          {{$value->document}}</li>

                                                                          <li><a  href="{{URL::to('uploads/'.$value->document)}}" download>Download</li>

                                                                        <li> <a onclick="return confirm('Are you sure you want to delete?');" href="{{URL::to('project-doc-delete/'.$value->id)}}"><i class="fas fa-times close_doc"></i></a></li>

                                                                        @endforeach

                                                                     </ol>

                                                                  </div>

                                                               </div>

                                                            </div>

                                                         </div> -->

                                                        <!--  <div class="card">

                                                          <?php   $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category','Form2')->get();  ?>

                                                            <div class="card-header" id="headingTwo">

                                                               <h2 class="mb-0">

                                                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                                                  Form 2

                                                                  <span class="plus_icon">

                                                                  <i class="fas fa-plus"></i>

                                                                  </span>

                                                                  <span class="minus_icon">

                                                                  <i class="fas fa-minus"></i>

                                                                  </span>

                                                                  </button>

                                                               </h2>

                                                            </div>

                                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">

                                                               <div class="card-body uploaded_item_list">

                                                                  <div class="inner_body">

                                                                     <ol>

                                                                       @foreach($projectdoc as $value)

                                                                        <li>

                                                                          {{$value->document}}</li>

                                                                          <li><a  href="{{URL::to('uploads/'.$value->document)}}" download>Download</li>

                                                                        <li> <a onclick="return confirm('Are you sure you want to delete?');" href="{{URL::to('project-doc-delete/'.$value->id)}}"><i class="fas fa-times close_doc"></i></a></li>

                                                                        @endforeach

                                                                     </ol>

                                                                  </div>

                                                               </div>

                                                            </div>

                                                         </div> -->

                                                         <!-- <div class="card">

                                                            <div class="card-header" id="headingThree">

                                                               <h2 class="mb-0">

                                                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                                                  EIA Report

                                                                  <span class="plus_icon">

                                                                  <i class="fas fa-plus"></i>

                                                                  </span>

                                                                  <span class="minus_icon">

                                                                  <i class="fas fa-minus"></i>

                                                                  </span>

                                                                  </button>

                                                               </h2>

                                                            </div>

                                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">

                                                              <?php   $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category','EIA')->get();  ?>

                                                               <div class="card-body uploaded_item_list">

                                                                  <div class="inner_body">

                                                                     <ol>

                                                                      @foreach($projectdoc as $value)

                                                                        <li>

                                                                          {{$value->document}}</li>

                                                                          <li><a  href="{{URL::to('uploads/'.$value->document)}}" download>Download</li>

                                                                        <li> <a onclick="return confirm('Are you sure you want to delete?');" href="{{URL::to('project-doc-delete/'.$value->id)}}"><i class="fas fa-times close_doc"></i></a></li>

                                                                        @endforeach

                                                                     </ol>

                                                                  </div>

                                                               </div>

                                                            </div>

                                                         </div> -->



<!-- 
                                                         <div class="card">

                                                            <div class="card-header" id="headingThree">

                                                               <h2 class="mb-0">

                                                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                                                  EIA Report

                                                                  <span class="plus_icon">

                                                                  <i class="fas fa-plus"></i>

                                                                  </span>

                                                                  <span class="minus_icon">

                                                                  <i class="fas fa-minus"></i>

                                                                  </span>

                                                                  </button>

                                                               </h2>

                                                            </div>

                                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">

                                                              <?php   $projectdoc = DB::table('project_document')->where('project_id',$id)->where('category','EIA')->get();  ?>

                                                               <div class="card-body uploaded_item_list">

                                                                  <div class="inner_body">

                                                                     <ol>

                                                                      @foreach($projectdoc as $value)

                                                                        <li>

                                                                          {{$value->document}}</li>

                                                                          <li><a  href="{{URL::to('uploads/'.$value->document)}}" download>Download</li>

                                                                        <li> <a onclick="return confirm('Are you sure you want to delete?');" href="{{URL::to('project-doc-delete/'.$value->id)}}"><i class="fas fa-times close_doc"></i></a></li>

                                                                        @endforeach

                                                                     </ol>

                                                                  </div>

                                                               </div>

                                                            </div>

                                                         </div> -->




                                                      </div>

                                                   </div>

                                                </div>

                                             </div>

                                          </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </form>

                        </div>



                 <!--  -->

               </div>

                <div class="row">

                        <div class="col-xs-12 col-sm-12">

                           <div class="back_btn_org">

                              <a href="{{URL::to('/Project-list')}}">Back</a>

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

@section('extra_js')
<script type="text/javascript">

document.querySelector("#file-upload").onchange = function(){
  document.querySelector("#file-name").textContent = this.files[0].name;
}

        $(document).ready(function() {
  $("#attachment").validate({
    rules: {
      selectcatefory : {
        required: true,
        
      },
       task_upload : {
        required: true,
        
        
      },

   
    },

  });
});
    </script>





@stop