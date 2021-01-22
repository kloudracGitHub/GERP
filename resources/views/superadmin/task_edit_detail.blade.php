@extends('superadmin_layout')   @section('content')    @section ('extra_css')     

<style type="text/css">       fieldset       {

  padding: 12px;

  background: #eee;

  }

  legend{

    border: 1px solid #eee;

    background-color: #fff;

    display: inline-block;

    width: auto;

    padding: 5px;

    font-size: 15px;

    font-weight: 500;

  }

</style>   @stop 

<div class="content-page">            

  <!-- Start content -->            

  <div class="content p-0">                

    <div class="container-fluid">                     @if ($errors->any())                   

      <div class="alert alert-danger">                   

        <ul>                   @foreach ($errors->all() as $error)                   

          <li>{{ $error }}

          </li>                   @endforeach                   

        </ul>                   

      </div>                   @endif                      

      <div class="col-xs-8">            @if(Session::has('alert-success'))            

        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('alert-success') }}

        </p>            @endif            @if ($message = Session::get('warn-edit-task-detail'))            

        <div class="alert alert-danger alert-block">               

          <strong>{{ $message }}

          </strong>            

        </div>            @endif         

      </div>                    

      <div class="page-title-box">                        

        <div class="row align-items-center bredcrum-style">                            

          <div class="col-sm-6">                                

            <h4 class="page-title">Task Details
            </h4>                            

          </div>                        
          <div class="col-sm-6">                                
               <a class="btn btn-primary float-right" href="javascript: history.go(-1)">Back</a>
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

                  <h3>                                                Condition Details - {{$taskData[0]['condition_no']}}                                            

                  </h3>                                        

                </div>                                        

                <div class="col-sm-5">                                            

                  <h4 class="page-title project_super">{{ucwords($projectshow->project_name??'')}}

                  </h4>                                        

                </div>                                    

              </div>                                

            </div>                            

          </div>                            

          <div class="col-xs-12 col-sm-12">                                

            <div class="task_header">                                    

              <div class="row">                                        

                <div class="col-xs-12 col-sm-6">                                            

                  <h5>Task Details

                  </h5>                                        

                </div>                                        

                <div class="col-xs-12 col-sm-2">                                            

                  <h5>Task Last Date

                  </h5>                                        

                </div>                                        

                <div class="col-xs-12 col-sm-2">                                            

                  <h5>Status

                  </h5>                                        

                </div>                                        

                <div class="col-xs-12 col-sm-2">                                            

                  <h5>Probability

                  </h5>                                        

                </div>                                    

              </div>                                

            </div>                                

            <form class="court-info-form" id="task_remarks" role="form" method="POST" action="{{URL::to('/Task-edit-detail/'.$id)}}"  enctype="multipart/form-data">                                                    

              <input type="hidden" name="_token" value="{{ csrf_token() }}">                                

              <div class="task_body">                                                                     

                <div class="row">                                        

                  <div class="col-xs-12 col-sm-6">                           

                    <p>{{$taskData[0]['task_name']}}

                    </p>                        

                  </div>                        

                  <div class="col-xs-12 col-sm-2">                           

                    <p>{{date('d-m-Y',strtotime($taskData[0]['end_date']))}}

                    </p>                        

                  </div>                                                             

                  <?php $count = DB::table('grc_status')->get();?>                                        

                  <div class="col-xs-12 col-sm-2">                                            

                    <select class="task_probability" name="taskstatus">                                                

                      <option value="0">Status

                      </option>                                                @foreach($count as $ct)                                                

                      <option value="{{$ct->status_name}}" @if($taskData[0]['task_status'] == ($ct->status_name)) selected @endif>{{$ct->status_name}}

                      </option>                                                @endforeach                                            

                    </select>                                        

                  </div>                                        

                  <div class="col-xs-12 col-sm-2">                                                                                     

                    <select name="pro" class="task_probability">                                                

                      <option value="" @if($taskData[0]['Probability'] == "0%") selected @endif>0%

                      </option>                                                

                      <option value="10%" @if($taskData[0]['Probability'] == "10%") selected @endif>10%

                      </option>                                                

                      <option value="20%" @if($taskData[0]['Probability'] == "20%") selected @endif>20%

                      </option>                                                

                      <option value="30%" @if($taskData[0]['Probability'] == "30%") selected @endif>30%

                      </option>                                                

                      <option value="40%" @if($taskData[0]['Probability'] == "40%") selected @endif>40%

                      </option>                                                

                      <option value="50%" @if($taskData[0]['Probability'] == "50%") selected @endif>50%

                      </option>                                                

                      <option value="60%" @if($taskData[0]['Probability'] == "60%") selected @endif>60%

                      </option>                                                

                      <option value="70%" @if($taskData[0]['Probability'] == "70%") selected @endif>70%

                      </option>                                                

                      <option value="80%" @if($taskData[0]['Probability'] == "80%") selected @endif>80%

                      </option>                                                

                      <option value="90%" @if($taskData[0]['Probability'] == "90%") selected @endif>90%

                      </option>                                                

                      <option value="100%" @if($taskData[0]['Probability'] == "100%") selected @endif>100%

                      </option>                                                

                    </select>                                        

                  </div>                                    

                </div>                                                                      

                <!--<div class="row">                                    -->

                <!--  <div class="col-xs-12 col-sm-6">                                       -->

                <!--    <div class="task_history">                                          -->

                <!--      <h4>                                             -->

                <!--        <a data-toggle="collapse" href="#figureAtSite" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">   -->
                <!--        Figure at Report                    -->

                <!--          <span class="plus_icon">+-->

                <!--          </span>                                             -->

                <!--          <span class="minus_icon">--->

                <!--          </span>                                             -->

                <!--        </a>                                          -->

                <!--      </h4>  -->

                      

                      

                      

                      

                <!--      <div class="row">                                             -->

                <!--        <div class="col">                                                -->

                <!--          <div class="collapse multi-collapse show" id="figureAtSite">                                                   -->

                <!--            <div class="card card-body task_history_details">                                                                                                                 -->

                <!--              <div class="form-group">                                                              -->

                <!--                <textarea rows="3" cols="8" name="figuresite" id="figuresite" maxlenght="500" class="wpcf7-form-control wpcf7-textarea form-control event-tag-name" aria-invalid="false">-->

                <!--                </textarea>                                                            -->

                <!--              </div>                                                                                                           -->

                <!--            </div>                                                -->

                <!--          </div>                                             -->

                <!--        </div>                                          -->

                <!--      </div>                                       -->

                <!--    </div>                                    -->

                <!--  </div>     -->
                <!--  <div class="col-xs-12 col-sm-6">                                       -->

                <!--    <div class="task_history">                                          -->

                <!--      <h4>                                             -->

                <!--        <a data-toggle="collapse" href="#actualAtSite" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">                                             Actual at Report                                          -->

                <!--          <span class="plus_icon">+-->

                <!--          </span>                                             -->

                <!--          <span class="minus_icon">--->

                <!--          </span>                                             -->

                <!--        </a>                                          -->

                <!--      </h4>                                          -->

                <!--      <div class="row">                                             -->

                <!--        <div class="col">                                                -->

                <!--          <div class="collapse multi-collapse show" id="actualAtSite">                                                   -->

                <!--            <div class="card card-body task_history_details">                                                                                                                 -->

                <!--              <div class="form-group">                                                             -->

                <!--                <textarea rows="3" cols="8" name="actualsite" maxlenght="500"  class="form-control">-->

                <!--                </textarea>                                                            -->

                <!--              </div>                                                                                                            -->

                <!--            </div>                                                -->

                <!--          </div>                                             -->

                <!--        </div>                                          -->

                <!--      </div>                                       -->

                <!--    </div>                                    -->

                <!--  </div>  -->

                  

                <!--  <div class="col-sm-12 m-t-10">-->

                <!--    <fieldset class="form-group">                                    -->

                <!--  <legend>File Attachment-->

                <!--  </legend>                                     -->

                <!--  <div class="row m-t-20">                                      -->

                <!--    <div class="col-xs-12 col-sm-6">                                          -->

                <!--      <input type="file" id="attfileimg" name="attfileimg" onchange="uploadprofile()" >                                      -->

                <!--    </div>                                      -->

                <!--    <div class="col-xs-12 col-sm-6">                                         -->

                <!--      <input type="text" id="filename" class="form-control" name="filename" style="width:100%">                                      -->

                <!--    </div>                                    -->

                <!--  </div>                                  -->

                <!--</fieldset>                 -->

                <!--  </div>-->

                  

                <!--</div>				-->

                <!--<div class="remarks_upload_wrapper">					-->

                <!--  <h5 style="margin-top:10px;">Hints-->

                <!--  </h5>					-->

                <!--  <div class="row">						-->

                <!--    <div class="col-xs-12 col-sm-12">							-->

                <!--      <div class="task_remarks">                                                    			-->

                <!--        <textarea name="hints" rows="6" class="task_remarks_input"  maxlenght="500" placeholder="Enter Remarks">-->

                <!--        </textarea>                                                			-->

                <!--      </div>						-->

                <!--    </div>					-->

                <!--  </div>				-->

                <!--</div>                                 -->

                                 

                <div class="remarks_upload_wrapper">                                        

                  <h5>Remarks

                  </h5>                                        

                  <div class="row">                                            

                    <div class="col-xs-12 col-sm-6">                                                

                      <div class="task_remarks">                                                    

                        <textarea name="taskRemarks" rows="6" class="task_remarks_input"  maxlenght="500" placeholder="Enter Remarks"></textarea>                                                

                      </div>                                            

                    </div>                                            

                    <div class="col-xs-12 col-sm-6">                                                

                      <div class="task_upload_wrapper">                                                                                                            

                        <div class="uploading_task">                                                            

                          <img src="{{URL::to('assets/images/uploa_icon.png')}}" alt="" title="">                                                            

                          <input type="file" name="task_upload[]" multiple id="fileChooser" onchange="return ValidateFileUpload()">                                                        

                        </div>                                                        

                        <p>Accept JPG, GIF, PNG, PDF, WORD and Max 50 MB

                        </p>                                                        

                                                                         

                        <div class="filenames">

                          <ul>

                          </ul>

                        </div>                                                    

                        </form>                                                    

                      <!--<div class="task_line_item">-->                                                        

                      <!--<ol>-->                                                        

                      <!--  <li>Line Item 1 uploaded  <i class="fas fa-times close_doc"></i></li>-->                                                        

                      <!--        <li>Line Item 2 uploaded  <i class="fas fa-times close_doc"></i></li>-->                                                        

                      <!--        <li>Line Item 3 uploaded  <i class="fas fa-times close_doc"></i></li>-->                                                        

                      <!--</ol>-->                                                    

                      <!--</div>-->                                                

                    </div>                                            

                  </div>                                            

                  <div class="col-xs-12 col-sm-12">                                                

                    <div class="submit_task_details">                                                    

                      <input type="submit" name="submittask" class="submit_task" value="Save">                                                

                    </div>                                            

                  </div>                                        

                </div>                                    

                </form>                                    

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

<div id="addproject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"    aria-hidden="true">    

  <div class="modal-dialog">        

    <div class="modal-content">            

      <div class="modal-header">                

        <h5 class="modal-title mt-0" id="myModalLabel">Create a New Project

        </h5>                

        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×

        </button>            

      </div>            

      <div class="modal-body">                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Project Name

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="text" value="" id="example-text-input">                    

          </div>                

        </div>                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Project ID

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="text" value="" id="example-text-input">                    

          </div>                

        </div>                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Project Type

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="text" value="" id="example-text-input">                    

          </div>                

        </div>                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Organization ID

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">                    

          </div>                

        </div>                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Status

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="text" value="" id="example-text-input">                    

          </div>                

        </div>                

        <div class="form-group row">                    

          <label for="example-text-input" class="col-sm-4 col-form-label">Status

          </label>                    

          <div class="col-sm-8">                        

            <input class="form-control" type="mail" value="" id="example-text-input">                    

          </div>                

        </div>            

      </div>            

      <div class="modal-footer">                

        <button type="button" class="btn btn-primary waves-effect">Create Project

        </button>                

        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Cancel

        </button>            

      </div>        

    </div>    

  </div>

</div>

<!-- /.modal-content -->

</div>

<!-- /.modal-dialog -->

<!-- Task History Modal -->

<div class="modal fade bd-example-task-history" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    

  <div class="modal-dialog modal-xl">        

    <div class="modal-content">            

      <div class="modal-header">                

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">                    

          <span aria-hidden="true">&times;

          </span>                

        </button>            

      </div>            

      <div class="modal-body">                

        <div class="task_report">                    

          <h2>Task Report

          </h2>                    

          <div class="table-responsive">                        

            <table class="table table-bordered table-striped">                            

              <thead>                                

                <tr>                                    

                  <th scope="col">Date

                  </th>                                    

                  <th scope="col">Remarks

                  </th>                                    

                  <th scope="col">Status

                  </th>                                    

                  <th scope="col">Probability

                  </th>                                    

                  <th scope="col">Attachment

                  </th>                                

                </tr>                            

              </thead>                            

              <tbody>                                

                <tr>                                    

                  <th scope="row">15-11-2019

                  </th>                                    

                  <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis.

                  </td>                                    

                  <td>New

                  </td>                                    

                  <td>10%

                  </td>                                    

                  <td>                                        Attachment Name                                        

                    <a href="#">download

                    </a>                                    

                  </td>                                

                </tr>                                

                <tr>                                    

                  <th scope="row">10-11-2019

                  </th>                                    

                  <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis.

                  </td>                                    

                  <td>Running

                  </td>                                    

                  <td>70%

                  </td>                                    

                  <td>                                        Attachment Name                                        

                    <a href="#">download

                    </a>                                    

                  </td>                                

                </tr>                                

                <tr>                                    

                  <th scope="row">20-10-2019

                  </th>                                    

                  <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis.

                  </td>                                    

                  <td>Running

                  </td>                                    

                  <td>60%

                  </td>                                    

                  <td>                                        Attachment Name                                        

                    <a href="#">download

                    </a>                                    

                  </td>                                

                </tr>                            

              </tbody>                        

            </table>                    

          </div>                

        </div>            

      </div>            

      <div class="modal-footer">                

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close

        </button>            

      </div>        

    </div>    

  </div>

</div>

<!-- Task History Modal -->

</div>   @stop   @section('extra_js')   

 <script type="text/javascript">



        $(document).ready(function() {
  $("#task_remarks").validate({
    rules: {
      pro : {
        required: true,
        
      },
       figuresite : {
        required: true,
        
        
      },
         actualsite : {
        required: true,
        
        
      },
         taskRemarks : {
        required: true,
        
        
      },

   
    },

  });
});
    </script>


<script type="text/javascript">     

function ValidateFileUpload() {

var fuData = document.getElementById('fileChooser');
var FileUploadPath = fuData.value;


if (FileUploadPath == '') {
    alert("Please upload an image");

} else {
    var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();



    if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                || Extension == "jpeg" || Extension == "jpg" || Extension == "pdf" || Extension == "docx" || Extension == "doc") {


            if (fuData.files && fuData.files[0]) {

                var size = fuData.files[0].size;

                if(size > 50000000){
                    alert("Maximum 50MB file Support");
                    $('#fileChooser').val('');
                    $('#blah').attr('src', '');
                    return;
                }else{
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(fuData.files[0]);
                }
            }

    } 


else {
        alert("Photo only allows file types of GIF, PNG, JPG, JPEG and BMP. ");
         $('#fileChooser').val('');
          $('#blah').attr('src', '');
    }
}}


  $(function() {

    $('#fileChooser').change(function(){

      for(var i = 0 ; i <= this.files.length ; i++){

        var filename = this.files[i].name;

        $('.filenames ul').append('<li class="name">' + filename + ' <i class="fa fa-times remove" aria-hidden="true"></i></li>');

      }

    }

                          );

  }

   );

  $(document).on('click','.remove',function(){

    $(this).parent().remove();

  }

                )   </script>   @stop

