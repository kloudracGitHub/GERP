 @extends('superadmin_layout')

   @section('content')

  <div class="content-page">

            <!-- Start content -->

            <div class="content p-0">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style">

                            <div class="col-sm-6">

                                <h4 class="page-title">Add Tasks</h4>

                            </div>

                            

                        </div>

                    </div>

                </div>

                

               @if(session::has('task-war'))

               

               <div class="alert alert-danger alert-dismissible fade show" role="alert">

  {{session::get('task-war')}}

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">

    <span aria-hidden="true">&times;</span>

  </button>

</div>

               

               @endif

               

                <div class="add_project_wrapper">

                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                               <form class="court-info-form" id="add_task"  role="form" method="POST" action="{{URL::to('/Task-add')}}"  enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="row">

                                        <!-- <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="orgId">Organization Id</label>

                                                <input type="text" name="orgId" id="orgId" value="GRC-001" class="form-control project_box" disabled="true">

                                            </div>

                                        </div> -->



                                      <?php

                                      

                                       $proname = DB::table('grc_project')
                                           ->join('alm_states','grc_project.state','=','alm_states.id')
                                      ->join('alm_cities','grc_project.city','=','alm_cities.id')
                                      ->join('main_currency','grc_project.currency_id','=','main_currency.id')
                                      ->join('grc_organization','grc_project.organization_id','=','grc_organization.id')
                                      ->join('grc_sector','grc_project.sector','=','grc_sector.id')
                                      ->join('grc_user','grc_project.project_manager','=','grc_user.id');

                                        if(session('role') == 'project_Manager'){

                                       $proname->where('grc_project.project_manager',session('userId'));


                                         }else{

                                        if(session('role') !='superadmin'){

                                       $proname->where('grc_project.organization_id','=',session('org_id'));
                          
                                        }
                                    }

                                        



                                         $project= $proname->select('grc_project.*')->get(); 



                                   

                                         

                                        ?>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="projectId">Project Name</label><span style="color:red;">*</span>

                                                <select name="projectId" id="projectId"  class="form-control project_box">

                                                <option value="">Select Option</option>

                                                 @foreach($project as $pro)

                                                 <option value="{{$pro->id}}">{{$pro->project_name}}</option>

                                                 @endforeach

                                                 </select>

                                                  @error('projectId')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                               

                                            </div>

                                        </div>





                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="taskname">Task Name</label><span style="color:red;">*</span>

                                                <input type="text" name="taskname" value="{{ old('taskname') }}" id="taskname" maxlength="60" class="form-control project_box">

                                                 @error('taskname')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="projectstate">State</label><span style="color:red;">*</span>

                                                <select name="projectstate" id="projectstate" class="form-control project_box">

                                                     <option value="">Select Option</option>

                                                 @foreach($statelist as $state)

                                                 <option value="{{$state->stateid}}">{{$state->name}}</option>

                                                 @endforeach

                                                 </select>

                                                  @error('projectstate')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="category">Category</label><span style="color:red;">*</span>

                                                <select name="category" id="category" class="form-control project_box">

                                                    <option value="">Select Option</option>

                                                    <option value="Generic">Generic</option>

                                                    <option value="Specific">Specific</option>

                                                </select>

                                                 @error('category')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="sector">Sector</label><span style="color:red;">*</span>

                                                <select name="sector" id="sector" class="form-control project_box">

                                                  <option value="">Select Option</option>

                                                    @foreach($sectorname as $tn)

                                                    <option value="{{$tn->id}}">{{$tn->sector_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('sector')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="conditionno">Condition No.</label><span style="color:red;">*</span>

                                                <input type="text" name="conditionno" id="conditionno" value="{{ old('conditionno') }}" maxlength="10" class="form-control project_box">

                                                 @error('conditionno')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="user_name">User</label><span style="color:red;">*</span>

                                                

                                                <select name="user_name" id="user_name" class="form-control project_box">

                                                        <option value="">Select Option</option>

                                                    @foreach($username as $un)

                                                    <option value="{{$un->id}}">{{$un->first_name}}  {{$un->last_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('user_name')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="tasktype">type</label><span style="color:red;">*</span>

                                                <select name="tasktype" id="tasktype" class="form-control project_box">

                                                        <option value="">Select Option</option>

                                                     @foreach($stagesname as $sgn)

                                                    <option value="{{$sgn->stage_name}}">{{$sgn->stage_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('tasktype')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="taskstatus">Task Status</label><span style="color:red;">*</span>

                                                <select name="taskstatus" id="taskstatus" class="form-control project_box">

                                                       <option value="">Select Option</option>

                                                   @foreach($statusname as $sn)

                                                    <option value="{{$sn->status_name}}">{{$sn->status_name}}</option>

                                                    @endforeach

                                                </select>

                                                 @error('taskstatus')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="startdate">Start Date</label><span style="color:red;">*</span>

                                                <input type="date" name="startdate" placeholder="dd/mm/yyyy" id="startdate" value="{{ old('startdate') }}" class="dateTxt form-control project_box">

                                                 @error('startdate')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="endDate">End Date</label><span style="color:red;">*</span>

                                                <input type="date" name="endDate" id="endDate" placeholder="dd/mm/yyyy" value="{{ old('endDate') }}" class="dateTxt form-control project_box">

                                                 @error('endDate')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="taskDescription">Task Description</label><span style="color:red;">*</span>

                                                <textarea rows="4" name="taskDescription" maxlength="255" id="taskDescription" class="form-control project_box">{{ old('taskDescription') }}</textarea>

                                                 @error('taskDescription')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="estimatedhours">Estimated Hours</label><span style="color:red;">*</span>

                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="estimatedhours" id="estimatedhours" maxlength="4"  value="{{ old('estimatedhours') }}" class="form-control project_box">

                                                 @error('estimatedhours')

                                                <div style="color:red;">{{ $message }}</div>

                                                @enderror	

                                            </div>

                                        </div>



                                        <div class="col-xs-12 col-sm-12 text-center">

                                                <button type="button" id="task_preview" class="previvew_btn" onclick="task_preview()">Preview</button>

                                                <input type="submit" name="submit"   value="Submit" class="submit_btn">

                                        </div>



                                        <!-- <div class="col-xs-12 col-sm-6">

                                            <div class="see_details">

                                                <p>Click <a href="task_details.html">here</a> to see project details.</p>

                                            </div>

                                        </div> -->

                                    </div>

                                </form> 

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
        <div id="preview" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title mt-0 header_color" id="myModalLabel">Preview Filled Task</h5>
            </div>
            <div class="modal-body">
                <div class="preview_mode">
                    <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Project Name</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="pro_name" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Task Name</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_name" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                      <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">State</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_state" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Category</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_cto" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Sector</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_sector" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Condition No.</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_condition" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                    <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">User</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_user" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Type</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_type" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                        <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Task Status</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_status" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Start Date</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_startdate" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">End Date</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="task_endate" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Estimated Hours</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="taskhr" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                    </div>
                       <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="row">
                                          <label for="empcode" class="col-lg-2 col-form-label">Task Description</label>
                                          <div class="col-lg-10 col-form-label">
                                             <label id="task_desc" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        </div>
                </div>
               <!--<div class="col-sm-12 p-0">-->
               <!-- 	<div class="table-responsive">-->

               <!--         <table class="table table-bordered table-striped">-->

               <!--            <tbody>-->
               <!--            	<tr>-->

               <!--               <th>Project Name</th>-->

               <!--               <td id="pro_name">-->
               <!--               </td>-->

               <!--               <th>Task Name</th>-->

               <!--               <td id="task_name"></td>-->

               <!--            </tr>-->

               <!--            <tr>-->

               <!--               <th>State</th>-->

               <!--               <td id="task_state"></td>-->

               <!--               <th>Category</th>-->

               <!--               <td id="task_cto"></td>-->

               <!--            </tr>-->

               <!--            <tr>-->

               <!--               <th>Sector</th>-->

               <!--               <td id="task_sector">-->
               <!--               </td>-->

               <!--               <th>Condition No.</th>-->

               <!--               <td id="task_condition">-->
               <!--               </td>-->

               <!--            </tr>-->

               <!--            <tr>-->

               <!--               <th>User</th>-->

               <!--               <td id="task_user"></td>-->

               <!--               <th>Type</th>-->

               <!--               <td id="task_type"></td>-->

               <!--            </tr>-->

               <!--            <tr>-->

               <!--               <th>Task Status</th>-->

               <!--               <td id="task_status"></td>-->

               <!--               <th>Start Date</th>-->

               <!--               <td id="task_startdate"></td>-->

               <!--            </tr>-->

               <!--            <tr>-->

               <!--               <th>End Date</th>-->

               <!--               <td id="task_endate"></td>-->

               <!--               <th>Estimated Hours</th>-->

               <!--               <td id="taskhr"></td>-->

               <!--            </tr>-->

               <!--         </tbody></table>-->

               <!--      </div>-->
               <!--</div>-->
               <!--<div class="col-12 p-0">-->
               <!--         <div class="form-group">-->
               <!--            <label for="prDescription">Task Description</label>-->
               <!--            <p id="task_desc"></p>-->
               <!--      </div>-->

               <!--   </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>

   @stop

   

   @section('extra_js')
   
    <script language="javascript" type="text/javascript">
   
        $(document).ready(function() {
  $("#add_task").validate({
    rules: {
      projectId : {
        required: true,
       
      },
       taskname : {
        required: true,
        minlength: 3,
        maxlength: 60,
      },
       role : {
        required: true,
        
      },
      mobile : {
        required: true,
        minlength: 10,
        maxlength: 10,
        number: true,
      },
        alternate : {
        
        minlength: 10,
        maxlength: 10,
        number: true,
      },
     
      category : {
        required: true,
           
      },
      sector : {
        required: true,
           
      },
      conditionno : {
        required: true,
        number: true,
           
      },
       user_name : {
        required: true,
      
           
      },
         tasktype : {
        required: true,
      
           
      },
         taskstatus : {
        required: true,
      
           
      },
       startdate : {
        required: true,
      
           
      },
       endDate : {
        required: true,
      
           
      },
       taskDescription : {
        required: true,
        
      },
       projectstate : {
        required: true,
        
      },
       estimatedhours : {
        required: true,
        number: true,
        
      },
       pincode : {
        required: true,
        minlength: 6
      },
       
      age: {
        required: true,
        number: true,
        min: 18
      },
      emailaddress: {
        required: true,
        email: true
      },
      alt_emailaddress: {
        
        email: true
      },
      weight: {
        required: {
          depends: function(elem) {
            return $("#age").val() > 50
          }
        },
        number: true,
        min: 0
      }
    },
    messages : {
      taskname: {
        minlength: "Task Name should be at least 3 characters",
        maxlength: "Task Name should be at Max 60 characters",
      },
        lname: {
        minlength: "Last Name should be at least 3 characters",
        maxlength: "Last Name should be at Max 60 characters",
      },
      mobile: {
        minlength: "Mobile No should be at least 10 Digit"
      },
       alternate: {
        minlength: "Mobile No should be at least 10 Digit"
      },
      pincode: {
        minlength: "Pin Code should be at least 6 Digit"
      },
      age: {
        required: "Please enter your age",
        number: "Please enter your age as a numerical value",
        min: "You must be at least 18 years old"
      },
      emailaddress: {
        email: "The email should be in the format: abc@domain.tld"
      },
      alt_emailaddress: {
        email: "The email should be in the format: abc@domain.tld"
      },
      weight: {
        required: "People with age over 50 have to enter their weight",
        number: "Please enter your weight as a numerical value"
      }
    }
  });
});
    </script>


<script>
    $('#task_preview').click(function()
    {
         var projectId =$("#projectId option:selected").text();
            
           
            
            var taskname = document.getElementById("taskname").value;


           var projectstate =$("#projectstate option:selected").text();
            var category = document.getElementById("category").value;
            var sector = document.getElementById("sector").value;
            var conditionno =document.getElementById("conditionno").value;
            var user_name = $("#user_name option:selected").text();
            var tasktype = $("#tasktype option:selected").text();
            var taskstatus = document.getElementById("taskstatus").value;
            var startdate=document.getElementById("startdate").value;
              var endDate=document.getElementById("endDate").value;
var taskDescription=document.getElementById("taskDescription").value;
      var estimatedhours=  document.getElementById("estimatedhours").value;    
           
            $("#pro_name").html(projectId);
            $("#task_name").html(taskname);
            $("#task_state").html(projectstate);
            $("#task_cto").html(category);
            $("#task_sector").html(sector);
            $("#task_condition").html(conditionno);
            $("#task_user").html(user_name);
            $("#task_type").html(tasktype);
            $("#task_status").html(taskstatus);
             $("#task_startdate").html(startdate);
            $("#task_endate").html(endDate);
            $("#task_desc").html(taskDescription);
            $("#taskhr").html(estimatedhours);
        $('#add_task').validate();
        if ($('#add_task').valid()) // check if form is valid
        {
            $('#preview').modal('show');
        }
        else 
        {
            // just show validation errors, dont post
        }
    });

</script>


   

   <script>



$(document).on('click','.submit_btn',function(){

    

    fromdate = $('#startdate').val();

    todate = $('#endDate').val();

    

    

      var d1 = Date.parse(fromdate);

                  var d2 = Date.parse(todate);

                  if (d1 > d2) {

                      alert ("Please Select Valid Date");

                      var error = 0;

                      return false;

                  }

    

});

$(function(){$('.dateTxt').datepicker(); }); 
function task_preview(){
  debugger
  var pro_name_select = document.getElementById("projectId");
  var pro_name = pro_name_select.options[pro_name_select.selectedIndex].text;
   var task_name=document.getElementById("taskname").value;
   var task_state_select=document.getElementById("projectstate");
     var task_state = task_state_select.options[task_state_select.selectedIndex].text;
  var task_cto_select=document.getElementById("category");
       var task_cto = task_cto_select.options[task_cto_select.selectedIndex].text;
   var task_sector_select=document.getElementById("sector");
          var task_sector = task_sector_select.options[task_sector_select.selectedIndex].text;
  var task_condition=document.getElementById("conditionno").value;
   var task_user_select=document.getElementById("user_name");
             var task_user = task_user_select.options[task_user_select.selectedIndex].text;
  var task_type_select=document.getElementById("tasktype");
               var task_type = task_type_select.options[task_type_select.selectedIndex].text;
    var task_status_select=document.getElementById("taskstatus");
                   var task_status = task_status_select.options[task_status_select.selectedIndex].text;
  var task_startdate=document.getElementById("startdate").value;
   var task_endate=document.getElementById("endDate").value;
  var taskhr=document.getElementById("estimatedhours").value;
  var task_desc=document.getElementById("taskDescription").value;
  document.getElementById("pro_name").innerHTML=pro_name;
    document.getElementById("task_name").innerHTML=task_name;
      document.getElementById("task_state").innerHTML=task_state;
        document.getElementById("task_cto").innerHTML=task_cto;
          document.getElementById("task_sector").innerHTML=task_sector;
            document.getElementById("task_condition").innerHTML=task_condition;
              document.getElementById("task_user").innerHTML=task_user;
                document.getElementById("task_type").innerHTML=task_type;
                  document.getElementById("task_status").innerHTML=task_status;
          document.getElementById("task_startdate").innerHTML=task_startdate;
            document.getElementById("task_endate").innerHTML=task_endate;
              document.getElementById("taskhr").innerHTML=taskhr;
                document.getElementById("task_desc").innerHTML=task_desc;
 }
</script>

   

   @stop