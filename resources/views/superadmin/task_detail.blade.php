@extends('superadmin_layout')
@section('extra_css')
<style>
.textarea {
    width: 600px;
    height: 200px;
    border: 1px solid black;
}
 .cke_top { display: none !important } 
</style>
@stop
@section('content')
<div class="content-page">
   <!-- Start content -->
   <div class="content p-0">
      <div class="container-fluid">
         <div class="col-xs-8">
            @if(Session::has('alert-success'))
            <p class="alert alert-info">{{ Session::get('alert-success') }}</p>
            @endif
            @if ($message = Session::get('warn-task-detail'))
            <div class="alert alert-danger alert-block">
               <strong>{{ $message }}</strong>
            </div>
            @endif
         </div>
         <div class="page-title-box">
            <div class="row align-items-center bredcrum-style">
               <div class="col-sm-6">
                  <h4 class="page-title">Task Details</h4>
               </div>
                <div class="col-sm-6">
                  <h4 class="page-title project_super">{{ucwords($projectshow->project_name??'')}}



@if(session('role') == 'superadmin')
 &nbsp; &nbsp;<a  onclick="return confirm('Are you sure you want to delete this Task?');" href="{{URL::to('/task_delele')}}/{{$id}}" class="btn btn-primary">Delete </a>  
 @endif</h4>
               </div>
               
            </div>
         </div>
      </div>
      <div class="tasks_details">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="compliance_condition">
                     <div class="row">
                        <div class="col-xs-12 col-sm-7">
                           <h3>
                              Condition Details - {{$taskData[0]['condition_no']}}
            
                              @if($taskData[0]['task_status'] != 'Completed')
                              <a href="{{URL::to('/Task-edit-detail/'.$id)}}" class="edit_task">Edit</a>
                              @endif
                           </h3>
                        </div>
                        <div class="col-sm-5">
                           <h4 class="page-title project_super"></h4>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xs-12 col-sm-12">
                  <div class="task_header">
                     <div class="row">
                        <div class="col-xs-12 col-sm-6">
                           <h5>Task Details</h5>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <h5>Task Last Date</h5>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <h5>Status</h5>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <h5>Probability</h5>
                        </div>
                     </div>
                  </div>
                  <div class="task_body">
                     <div class="row">
                        <div class="col-xs-12 col-sm-6">
                           <p>{{$taskData[0]['task_name']}}</p>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <p>{{date('d-m-Y',strtotime($taskData[0]['end_date']))}}</p>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <p>{{$taskData[0]['task_status']}}</p>
                        </div>
                        <div class="col-xs-12 col-sm-2">
                           <p>{{$taskData[0]['Probability']}}</p>
                        </div>
                        <!-- <div class="col-xs-12 col-sm-1">
                           <a href="#" class="edit_task">Edit</a>
                           </div> -->
                     </div>
                     <div class="row">
                                 <div class="col-xs-12 col-sm-6">
                                    <div class="task_history">
                                       <h4>
                                          <a data-toggle="collapse" href="#figureAtSite" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
                                          Figure at Report
                                          <span class="plus_icon">+</span>
                                          <span class="minus_icon">-</span>
                                          </a>
                                          <i class="mdi mdi-pencil float-right cursorpointer" data-toggle="modal" data-target="#figure_report" title="Edit"></i>
                                           <div class="modal" id="figure_report">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title mt-0 header_color">Figure at Report</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <form class="court-info-form add_project_wrapper p-0 texteditor">
            <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label> Figure at Report</label><span style="color:red;">*</span>
                                                
                                               
                                                <div class="textarea" id="figure_text" contenteditable="true">{!!$taskData[0]['figure']!!}</div>
                                               <div id="figure_error"></div>
                                            </div>
                                        </div>
                                        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" onclick="save_data('{{$id}}',1)" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
 
                                       </h4>
                                       <div class="row">
                                          <div class="col">
                                             <div class="collapse multi-collapse show" id="figureAtSite">
                                                <div class="card card-body task_history_details task_height">
                                                   <div class="figure_actual_site">
                                                      {!!$taskData[0]['figure']!!}
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-6">
                                    <div class="task_history">
                                       <h4>
                                          <a data-toggle="collapse" href="#actualAtSite" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
                                          Actual at Report
                                          <span class="plus_icon">+</span>
                                          <span class="minus_icon">-</span>
                                          </a>
                                            <i class="mdi mdi-pencil float-right cursorpointer" data-toggle="modal" data-target="#actual_report" title="Edit"></i>
                                            <div class="modal" id="actual_report">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title mt-0 header_color">Actual at Report </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           <form class="court-info-form add_project_wrapper p-0 texteditor">
            <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Actual at Report</label><span style="color:red;">*</span>
                                               
                                               
                                                   <div class="textarea" id="actual_text" contenteditable="true">{!!$taskData[0]['actual']!!}</div>
                                               <div id="actual_error"></div>
                                            </div>
                                        </div>
                                        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" onclick="save_data('{{$id}}',2)" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
                                       </h4>
                                       <div class="row">
                                          <div class="col">
                                             <div class="collapse multi-collapse show" id="actualAtSite">
                                                <div class="card card-body task_history_details task_height">
                                                   <div class="figure_actual_site">
                                                     {!!$taskData[0]['actual']!!}
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                     <div class="row">
                        <div class="col-xs-12 col-sm-6">
                           <div class="task_body_details">
                              <div class="hint_details task_history">
                                 <h4>
                                      <a data-toggle="collapse" href="#hints" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
                                          Hints
                                          <span class="plus_icon">+</span>
                                          <span class="minus_icon">-</span>
                                          </a>
                                      					
                                 <!--<a href="javscript:void(0);"><img src="{{URL::to('assets/images/eye.png')}}" alt="" title=""></a>-->
                                       <i class="mdi mdi-pencil float-right cursorpointer" data-toggle="modal" data-target="#hint" title="Edit"></i>
                                       </h4>
                                         <div class="row">
                                          <div class="col">
                                             <div class="collapse multi-collapse show" id="hints">
                                                <div class="card card-body task_history_details task_height">
                                                  @foreach($hints as $hintss)
                                                   <div class="figure_actual_site">

                                                      {!!$hintss->hints!!}
                                                   </div>
                                                   @endforeach
                                                   
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="modal" id="hint">
                                       <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title mt-0 header_color">Hint</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            
                        <div class="col-xs-12 col-sm-12 hint_edit">
                <div class="compliance_condition">
                    <div class="col-sm-12">
                        <div class="row">
                             <h3><a class="edit_task cursorpointer" onclick="show_add_hints()">Add Hint</a></h3>
                              <div id="addhint" class="display-none col-12 m-t-10 p-10" style="border:1px solid #ededed">
                              <div class="form-group texteditor">
                                    <label>Hint</label><span style="color:red;">*</span>
                                  <!--   <textarea id="hint_text" maxlenght="500" id="hint_text" class="form-control"></textarea> -->
                                     <div class="textarea" id="hint_text" contenteditable="true"></div>
                                    <div id="hint_error"></div>
                                    <input type="hidden" id="hint_id">
                              </div>
                              <div class="col-12 p-0 text-right">
                                  <button class="btn btn-primary" onclick="add_more_hint('{{$id}}')">Save</button>
                                   <button class="btn btn-danger" id="hintcancel">Cancel</button>
                                    
                              </div>
                            </div>
                            
                        </div>
                        <div class="row m-t-20">
                              <div class="col-12 display-none p-0" id="hintedit">
                                    <div class="row">
                                        <div class="col-sm-10">
                                        <input type="text" width="100%" class="form-control inline-block">
                                        </div>
                                         <div class="col-sm-2">
                                        <i class="btn btn-primary mdi mdi-check"></i>
                                        <i class="btn btn-danger mdi mdi-window-close"></i>
                                        </div>
                                        </div>
                                    </div>  
                        </div>
                        <div class="row m-t-10">
                                
                                     @foreach($hints as $hintss)
                                     <div class="col-12">
                                                
                                                      {!!$hintss->hints!!}
                                                      <a onclick="return confirm('Are you sure you want to delete ?');" href="{{URL::to('delete-hint')}}/{{$hintss->id}}">
                                                      <i  class="mdi mdi-delete text-danger cursorpointer font-18 m-r-10 float-right" title="Delete" ></i>
                                                    </a>

                                                    <span onclick="edit_hind('{{$hintss->id}}')"> <i  class="mdi mdi-pen text-warning cursorpointer font-18 m-r-10 float-right" title="Edit" ></i>
                                                        </span>
                                                        
                                                    
                                                 </div>
                                                   @endforeach 
                                     
                                
                               
                        </div>
                    </div>
                </div>
               
    
                                         
                                        </div>
                                        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
                                       </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="task_body_details">
                                <div class="hint_details task_history">
                                    <h4>
                                     <a data-toggle="collapse" href="#fileattach" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
                                         Hints Attachment
                                          <span class="plus_icon">+</span>
                                          <span class="minus_icon">-</span>
                                          </a>
                                         <i class="mdi mdi-pencil float-right cursorpointer" data-toggle="modal" data-target="#fileattachment" title="Edit"></i>
                                                 <div class="modal" id="fileattachment">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title mt-0 header_color">File Attachment </h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           <form class="court-info-form add_project_wrapper p-0">
             <div class="row m-t-20">                                      
                    <div class="col-xs-12 col-sm-6">                                          
                      <input type="file" id="attfileimg" name="attfileimg"  > 
                      <span id="attfileimg_error"></span>
                    </div>                                      
                                                     
                  </div>
                                        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" onclick="uploadprofile_upload('{{$id}}')" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
                                    </h4>
                                    <div class="row">
                                        <div class="col">
                                            <div class="collapse multi-collapse show" id="fileattach">
                                                <div class="card card-body task_history_details task_height">
                                                   <div class="figure_actual_site">
                                                       @foreach($files as $file)
                                                    <p><a download href="{{URL::to('/attachement')}}/{{$file->files}}" class="font-blue">{{$file->files}}</a> <a onclick="return confirm('Are you sure you want to delete ?');" href="{{URL::to('delete-task-file')}}/{{$file->id}}"><i  class="fa fa-times float-right m-t-10"></i></p>
                                                    @endforeach
                                                   </div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <!--    <fieldset class="form-group">                                    -->
                <!--  <legend>-->
                <!--  </legend>                                     -->
                                                 
                <!--</fieldset>  -->
                        </div>
                     </div>
                     <div class="remarks_upload_wrapper">
                        <!-- <h5>Remarks</h5> -->
                        <div class="row">
                           
                           <div class="col-xs-12 col-sm-12">
                              <div class="task_history">
                                 <h4>
                                    <a data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">
                                    Task Report
                                    <span class="plus_icon">+</span>
                                    <span class="minus_icon">-</span>
                                    </a>
                                 </h4>
                                 <div class="">
                                    <div class="row">
                                       <div class="col">
                                          <div class="collapse multi-collapse show" id="multiCollapseExample1">
                                             <div class="card card-body task_history_details">
                                                <div class="task_report">
                                                   <!-- <h2>Task Report</h2> -->
                                                   <div class="table-responsive">
                                                      <table class="table table-bordered table-striped">
                                                         <thead>
                                                            <tr>
                                                               <th scope="col" style="width: 13%;">Date</th>
                                                               <th scope="col">Remarks</th>
                                                               <th scope="col">Status</th>
                                                               <th scope="col">Probability</th>
                                                               <th scope="col" style="width: 15%;">Attachment</th>
                                                            </tr>
                                                         </thead>
                                                         
                                                         <tbody>
                                                            @foreach($taskdoc as $td)
                                                            <?php $date = $td['cdate'];
                                                     $finalDate = explode(' ',$date);
                                                     $data = $finalDate[0];
                                                    $Dates = date("d-m-Y", strtotime($data));
                                                    
                                                    $file = explode('|',$td['document']);
                                                    ?>
                                                            <tr>
                                                               <td scope="row">{{date('d-m-Y h:i:s',strtotime($date))}}</td>
                                                               <td>{{$td['task_remark']}}</td>
                                                               <td>{{$td['task_status']}}</td>
                                                               <td>{{$td['Probability']}}</td>
                                                               <td>
                                                                    @if(!empty($td['document']))
                                                                 @foreach($file as $files)
                                                                 {{$files}}
                                             <a href="{{URL::to('/Task-documentdownload/')}}/{{$files}}" target="_blank">download</a>
                                              @endforeach
                                              @endif
                                           
                                                               </td>
                                                            </tr>
                                                           @endforeach
                                                      @if(count($taskdoc)==0)
                    <tr>
                           <td colspan = '8' align = 'center'> <b> No report found</b>
                           </td>
                        </tr>
                @endif
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </div>
                                                @if(count($taskdoc)>0)
                                              <a href="#" class="remarks_hist" data-toggle="modal" data-target=".bd-example-task-history">View More</a>
                                              @endif
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!--<div class="col-xs-12 col-sm-12">-->
                           <!--   <div class="submit_task_details">-->
                           <!--      <input type="submit" name="submittask" class="submit_task" value="Save">-->
                           <!--   </div>-->
                           <!--</div>-->
                        </div>
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
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
</div>
    <div class="modal fade bd-example-task-history" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="task_report">
                     <h2>Task Report</h2>
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                           <thead>
                              <tr>
                                 <th scope="col" style="width: 13%;">Date</th>
                                 <th scope="col">Remarks</th>
                                 <th scope="col">Status</th>
                                 <th scope="col">Probability</th>
                                 <th scope="col" style="width: 15%;">Attachment</th>
                              </tr>
                           </thead>
                           <tbody>
                             @foreach($taskdoc as $td)
                            
                                                            <?php $date = $td['cdate'];
                                                     $finalDate = explode(' ',$date);
                                                     $data = $finalDate[0];
                                                     $file = explode('|',$td['document']);
                                                    $Dates = date("d-m-Y", strtotime($data));?>
                                                            <tr>
                                                               <td scope="row">{{$td['cdate']}}</td>
                                                               <td>{{$td['task_remark']}}</td>
                                                               <td>{{$td['task_status']}}</td>
                                                               <td>{{$td['Probability']}}</td>
                                                               <td>  @if(!empty($td['document']))
                                                                     @foreach($file as $files)
                                                                 {{$files}}
      <a href="{{URL::to('/Task-documentdownload/')}}/{{$files}}" target="_blank">download</a>
      @endforeach
      @endif
                                                               </td>
                                                            </tr>
                                                           @endforeach
                                                      @if(count($taskdoc)==0)
                    <tr>
                           <td colspan = '8' align = 'center'> <b> No Remark Found</b>
                           </td>
                        </tr>
                @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
@stop


@section('extra_js')

<script type="text/javascript">

function show_add_hints(){
    $('#hint_text').val('');
    $('#hint_id').val('');
    $('#addhint').show();
}

function edit_hind(hint_id){
    
     var _token = "{{csrf_token()}}";
         $.ajax({
              
             url:siteurl+'/public/get_hint_id',
   
             type: "Post",
              data: {_token: _token,hint_id: hint_id},
            
             cache: false,
   
             dataType: 'json',

   
             success: function (response) {
                 
                 $('#hint_text').html(response.hint)
                 $('#hint_id').val(hint_id);
                 $('#addhint').show();
               
                  
             }
        })
    
}


function add_more_hint(task_id){
    
    var hint_text =  $("#hint_text").html();
    var hint_id =  $("#hint_id").val();
  
        hint_text1 =   hint_text.replace('<p><br></p>', '');
          hint_text1 =   hint_text1.replace('&nbsp;', '');
          hint_text1 =   hint_text1.replace('<p></p>', '');
       
    
              if(hint_text1.replace(/\s/g, '') ==''){
         $('#hint_error').text('Hints is Required').attr('style','color:red');
         $('#hint_error').show();
           error = 0;
              return false;
      }else{$('#hint_error').hide();  error = 1;}

 
    
    
     var _token = "{{csrf_token()}}";
         $.ajax({
              
             url:siteurl+'/public/update_hint_data',
   
             type: "Post",
              data: {_token: _token,task_id: task_id,hint_text:hint_text,hint_id:hint_id},
            
             cache: false,
   
             dataType: 'json',

   
             success: function (response) {
                 //console.log(response.data.docData4);
                alertify.success(response.msg);
                location.reload();
                  
             }
        })
    
}


      function uploadprofile_upload(task_id){
          
            var attfileimg =  $("#attfileimg").val();

    
              if(attfileimg ==''){
         $('#attfileimg_error').text('File is Required').attr('style','color:red');
         $('#attfileimg_error').show();
           error = 0;
              return false;
      }else{$('#attfileimg_error').hide();  error = 1;}
          
        

   formData  =  new FormData();
  var files = $('#attfileimg')[0].files[0];


formData.append('attfile', files);
formData.append('task_id', task_id);

   error =1;

      if(error ==1){

      var token = "{{csrf_token()}}"; 

      $.ajax({
      url: siteurl+'/public/attach-file',
      headers: {'X-CSRF-TOKEN': token},                          
      type: "POST",
      cache: false,
      dataType:'json',
      processData: false,
      contentType: false,
      data:formData,
      success:function(data){
        console.log(data);
        if(data.status ==200){
            
         alertify.success(data.msg) ;
         location.reload();
         
        }else{
            
             alertify.success(data.msg) ;
            
        }
       },
    });

      }


 }
  
function save_data(id,num_text){

      

      if(num_text == 1){
        var data_text =  $("#figure_text").html();
          data_text =   data_text.replace('<p><br></p>', '');
          data_text =   data_text.replace('&nbsp;', '');
          data_text =   data_text.replace('<p></p>', '');


                if(data_text.replace(/\s/g, '') ==''){
         $('#figure_error').text('Text is Required').attr('style','color:red');
         $('#figure_error').show();
           error = 0;
              return false;
      }else{$('#figure_error').hide();  error = 1;}

      }else if(num_text == 2){

        var data_text =  $("#actual_text").html();
           data_text =   data_text.replace('<p><br></p>', '');
          data_text =   data_text.replace('&nbsp;', '');
          data_text =   data_text.replace('<p></p>', '');

                     if(data_text.replace(/\s/g, '') ==''){
         $('#actual_error').text('Text is Required').attr('style','color:red');
         $('#actual_error').show();
           error = 0;
              return false;
      }else{$('#actual_error').hide();  error = 1;}

      }else if(num_text == 3){

         var data_text =  $("#hint_text").val();

                     if(data_text ==''){
         $('#hint_error').text('Text is Required').attr('style','color:red');
         $('#hint_error').show();
           error = 0;
              return false;
      }else{$('#hint_error').hide();  error = 1;}

      }
    
   
  
     var _token = "{{csrf_token()}}";
         $.ajax({
              
             url:siteurl+'/public/update_task_data',
   
             type: "Post",
              data: {_token: _token,id: id,data_text:data_text,num_text:num_text},
            
             cache: false,
   
             dataType: 'json',

   
             success: function (response) {
                 //console.log(response.data.docData4);
                alertify.success(response.msg);
                location.reload();
                  
             }
        })
     }

 $(document).ready(function(){
            $(document).on("click",".editfield",function(){
                debugger
                $("#hintedit").css("display","inline-block");
            })
            $(document).on("click",".mdi-window-close",function(){
                $(this).parent().parent().css("display","none");
            })
             $(document).on("click","#hintcancel",function(){
                $("#addhint").css("display","none");
            })
            
        })


</script>


@stop