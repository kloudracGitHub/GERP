@extends('superadmin_layout')



@section('extra_css')





<style>

ul li {
    min-width: 200px;
}
.dragging li.ui-state-hover {
    min-width: 240px;
}
.dragging .ui-state-hover a {
    color:green !important;
    font-weight: bold;
}
th,td {
    text-align: right;
    padding: 2px 4px;
    border: 1px solid;
}
.connectedSortable tr, .ui-sortable-helper {
    cursor: move;
}
.connectedSortable tr:first-child {
    cursor: default;
}
.ui-sortable-placeholder {
    background: yellow;
}

.duplicate {

    border: 1px solid red;

    color: red;

}



</style>



@stop



@section('content')

<div class="content-page">

   <!-- Start content -->

   <div class="content p-0">

      <div class="container-fluid">

         <div class="page-title-box">

            <div class="row align-items-center bredcrum-style">

               <div class="col-sm-6">

                  <h4 class="page-title">Project Details</h4>

               </div>

               <div class="col-sm-6">

                  <h4 class="page-title project_super">{{ucwords($projectshow->project_name??'')}}</h4>

               </div>

            </div>

         </div>

      </div>

      

        @if ($errors->any())

    <div class="alert alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif



@if(Session::has('msg'))

<div class="alert alert-primary"> {{Session::get('msg')}}  </div>



@endif



      <div class="project_details">

         <div class="container-fluid">

            <div class="row">

               <div class="col-xs-12 col-sm-12 col-md-12">

                  <div class="compliance_condition">

                     <div class="row">

                        <div class="col-xs-12 col-sm-7">

                           <h3>Compliance Condition</h3>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

            <!-- end row -->

         </div>

         

       

         <div class="project_details_collapse">

            <div class="container-fluid">

               <div class="row">

                  <div class="col-xs-12 col-sm-12 col-md-12">

                     <div class="inside_collapse">

                        <div class="accordion" id="accordionExample">

                           <div class="card">

                              <div class="card-header" id="headingOne">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">

                                    EC

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                    <div class="selected_condition">

                                         <label class="switch">

                                                        <input type="checkbox" data-con="EC" name="" class="chebox_true1" @if($projectshow->project_stage =='EC') checked    @endif ><span class="slider round"></span>

                                                                                                          </label>

                                       <!--<div class="custom_checkbox">-->

                                       <!--   <input class="styled-checkbox allchecked" id="checkbox_101" type="checkbox" value="value1">-->

                                       <!--   <label for="checkbox_101"></label>-->

                                       <!--</div>-->

                                    </div>

                                 </h2>

                              </div>

                              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                       <div class="row">

                                          <div class="col-xs-12 col-sm-8">



                                             <div class="edit_del_btns update_delete_btn">



                                                <a href="#" data-toggle="modal" data-target="#new_task_modalec">New</a>

                                                <a href="#" data-toggle="modal" data-target="#edit_task_modalec" class="editclass getedit">Edit</a>



                                             <a href="#" class="showss">Delete</a>

                                                 

                                                <!-- <a href="#" data-toggle="modal" data-target="#arrange_task_modal">Assign User</a> -->

                                             </div>

                                          

                                           

                                          </div>

                                          <div class="col-xs-12 col-sm-4">

                                             <div class="compliance_user_box">

                                                <h4>

                                                   <img src="assets/images/user.png" alt="" title="">

                                                   User

                                                </h4>

                                                <a href="#" class="assign_user_btn" data-toggle="modal" data-target="#arrange_task_modalec">Assign User</a>

                                                

                                             </div>

                                            <!--  <div class="users_list">

                                                <ul>

                                                   @foreach($userlist as $ul)

                                                   <li>

                                                      {{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})

                                                      <span><img src="assets/images/edit_icon.png" alt="" title=""></span>

                                                   </li>

                                                   @endforeach

                                                </ul>

                                             </div> -->

                                          </div>

                                          



                                          

                                          

                                          

                                          

                                          

                                          <div class="col-xs-12 col-sm-12">

                                                                    <div class="user_edit_wrapper">

                                                                        <div class="row">

                                                                            

                                                                             @foreach($con1 as $Con1)

                                                                             

                                                                          <?php

                                                              $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id', $Con1->conid)->where('grc_project_condition_doc_assign.project_id',$Con1->project_id)->where('grc_project_condition_doc_assign.condtion_status',2)->where('grc_project_condition_doc_assign.state_id',$Con1->state_id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                                                                             

                                                                             ?>

                                                                            

                                                                            <div class="col-xs-12 col-sm-8">

                                                                                

                                                                                

                                                                                <div class="custom_checkbox">

                                                                                    <input class="styled-checkbox getval" name="checkExp[]" data-s="{{$Con1->document_statement}}" data-userid="{{$selected_user_doc->user_id??$Con1->userId}}" id="checkbox_{{$Con1->id}}" type="checkbox" value="{{$Con1->conid}}">

                                                                                    <label title="" class="label-ellipses" for="checkbox_1" class="fw-500"> @if(strlen($Con1->document_statement) > 85)

                                                                                    

                                                                                    {{substr($Con1->document_statement,0,85)}}...

                                                                                    

                                                                                    @else

                                                                                    

                                                                                    {{$Con1->document_statement}}

                                                                                    

                                                                                    @endif</label>

                                                                                </div>

                                                                                

                                                                              



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_2" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_2">The project proponent shall ensure that stack height is 6 m more than highest tower.</label>-->

                                                                                <!--</div>-->



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_3" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_3">Vertical fenestration shall not exceed 60% of total wall area.</label>-->

                                                                                <!--</div>-->



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_4" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_4">The project proponent shall ensure that structural stability to withstand earthquake of mag 8.5 on Richter scale</label>-->

                                                                                <!--</div>-->

                                                                            </div>



                                                                            <div class="col-xs-12 col-sm-4">

                                                                                <div class="users_list">

                                                                                    <ul>

                                                                                        <li class="fw-500">

                                                                                             @if(!empty($selected_user_doc))

                                                                                            

                                                                                            

                                                                                              {{$selected_user_doc->first_name}} {{$selected_user_doc->last_name}}

                                                                                            

                                                                                            @else

                                                                                            

                                                                                           Not Assign

                                                                                            

                                                                                            

                                                                                            @endif

                                                                                        </li>

                                                                                        <!--<li>-->

                                                                                        <!--    Flora Hypas-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                        <!--<li>-->

                                                                                        <!--    Lucy Howaqrd-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                        <!--<li>-->

                                                                                        <!--    Lucy Howaqrd-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                            

                                                                            <div class="modal fade add_compliance" id="edit_task_modalec" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/edit-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     <div class="col-xs-12 col-sm-6">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Action</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-6" >

                        <input type="text" name="compliance"  class="form-control show" value="" placeholder="Enter Compliance Condition">

                         <input type="hidden" name="type" id="compliance" class="form-control compliance" > 

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <select class="form-control selecteduser" name="userid" required>
                         
                         <option value="">Select Option </option>
                            @foreach($userlist as $ul)

                            <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}}) </option>

                           @endforeach

                        </select>

                    

                     </div>

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="submit" class="sumit_compl" value="Save">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>







  <div class="modal fade add_compliance" id="arrange_task_modalec" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">User Assign</h5>
              <a href="#" class="assign_single_btn align-right" data-toggle="modal" data-target="#assign_task_modalec">Sellect All</a>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   
            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding comliance_rearrange_order">

                 <form class="court-info-form" id="ec"  role="form" method="POST" action="{{URL::to('/Project-assignuser/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <input type="hidden" name="doc_type" value="EC">

    

                 

                 <?php

                 

                

                  $sected_user = array();

                 $selected_user = DB::table('grc_project_condition_doc_assign')->where('doc_type', $Con1->doc_type)->where('project_id',$Con1->project_id)->where('condtion_status',1)->where('state_id',$Con1->state_id)->get();

                 if(!empty( $selected_user)){

                    foreach($selected_user as $selected_users){

                     $sected_user[] = $selected_users->user_id??0;

                    }

                 }



                

                 ?>

                  

                  @php($i = 1)

                  @if(!empty($project_condition_ec))

                  @foreach($project_condition_ec as $key =>  $re)

                     <div class="row">

                        <div class="col-xs-12 col-sm-1">

                           <p>{{$i++}}</p>

                        </div>

                        <div class="col-xs-12 col-sm-5">

                          {{$re->document}}

                          <input type="hidden" name="document[]" id=""  value="{{$re->document}}">
                          
                        

                        </div>

                        <div class="col-xs-12 col-sm-2">

                           <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{$re->condition_no}}" required>

                        </div>

                        

                           <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->id}}">

                       

                        <div class="col-xs-12 col-sm-2">

                           <select class="form-control" name="username[]" required>

                            <option value="">Option Select</option>

                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}"  @if(!empty($sected_user)) @if(in_array($ul->id,$sected_user)) selected  @endif @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                             

                           </select>

                        </div>

                        <div class="col-xs-12 col-sm-2">

                           <input type="date" name="timeFrame[]"  value="{{ $selected_user[$key]->last_date_task??''}}" class="form-control" placeholder="Enter Time-frame"  required>

                        </div>

                     </div>

                    @endforeach



              

                @endif
                
                
                
                
                            <div class="container text-center">
    
     <table class="table table-bordered pagin-table">
        <thead>
            <tr>
                <th width="50px">S.No</th>
                <th class="text-center">Condition</th>
                <!--<th>Order</th>-->
                 <th class="text-center">Users</th>
                 <th class="text-center">Last Date</th>
                
            </tr>
        </thead>
        <tbody>
           
   
       


                  <?php 

                  

                  

                  $sected_user = array();

                 

                  

                  $ReData = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.doc_type',$Con1->doc_type)->where('grc_project_condition_doc.project_id',$id)->orderBy('grc_project_condition_doc.condition_number','ASC')->get();?>

                  <div class="single_row">

                  @foreach($ReData as $ky =>  $re)



                  <?php

                  

                   $selected_user_doc = DB::table('grc_project_condition_doc_assign')->where('doc_id', $re->conid)->first();

                 

                  

                  ?>
                  
                <tr onmousedown="myFunctionEC(this)">
              <td > <span class="changeOrderEC" > {{$i++}}</span></td>
              <td class="text-left">
                          {{$re->document_statement}}

                          <input type="hidden" name="document[]" id=""  value="{{$re->document_statement}}">
                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">

               </td>
              <!--<td>  -->
                <!--<input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control check_order" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$ky+1}}" required>-->
               
              <!--</td>-->
              <td style="width:200px;">  
              <select class="form-control" name="username[]" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif   @else  @if($ul->id == $re->user_id??0) selected @endif     @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                              </select>
                              </td>
              <td>   <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{ $selected_user_doc->last_date_task??''}}" required>
              </td>
            </tr>

                    

                    @endforeach



                    @if(count($ReData)==0)

                    <tr>

                           <td colspan = '8' align = 'center'> <b> No Data Found</b>

                           </td>

                        </tr>

                @endif
                
                    </tbody>
                  </table>



                  </div>

                   
                  

                  <div class="col-xs-12 col-sm-12">

                     <input type="submit" name="addCompliance"  onclick="check_order()" class="sumit_compl" value="Save">

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

                                                                            

                                                                              @endforeach
                                                                              


                                                                            

                                                                        </div>

                                                                    </div>

                                                                </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>


    <div class="modal fade" id="assign_task_modalec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="assginAllEC" method="post" action="{{URL::to('/Project-assignuser-indiviable/'.$id)}}">
  <div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <select class="form-control" name="username" >
                            <option value="">Select Option </option>
                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach
                           </select>
  </div>
  <input type="hidden" name="stage" value="EC">
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="Date" class="form-control" name="endDate" onchange="getDatetoCheck(this.value,'EC','{{$id}}')" >
     <span id="EC_error"></span>
  </div>

  <button  id="EC_submit" type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

                           <div class="card">

                              <div class="card-header" id="headingTwo">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                    CTO

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                    <div class="selected_condition">

                                         <label class="switch">

                                                       <input type="checkbox" data-con="CTO"  class="chebox_true1" name="" @if($projectshow->project_stage =='CTO') checked    @endif ><span class="slider round"></span>

                                                                                                          </label>

                                       <!--<div class="custom_checkbox">-->

                                       <!--   <input class="styled-checkbox allchecked" id="checkbox_102" type="checkbox" value="value1">-->

                                       <!--   <label for="checkbox_102"></label>-->

                                       <!--</div>-->

                                    </div>

                                 </h2>

                              </div>

                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                       <div class="row">

                                          <div class="col-xs-12 col-sm-8">

                                             <div class="edit_del_btns update_delete_btn">

                                                <a href="#" data-toggle="modal" data-target="#new_task_modalcto">New</a>

                                                <a href="#" data-toggle="modal" data-target="#edit_task_modalcto" class="editclass getedit">Edit</a>

                                                <a href="#" class="showss">Delete</a>

                                                <!-- <a href="#" data-toggle="modal" data-target="#arrange_task_modal">Assign User</a> -->

                                             </div>

                                          

                                           

                                          </div>

                                          <div class="col-xs-12 col-sm-4">

                                             <div class="compliance_user_box">

                                                <h4>

                                                   <img src="assets/images/user.png" alt="" title="">

                                                   User

                                                </h4>

                                                <a href="#" class="assign_user_btn" data-toggle="modal" data-target="#arrange_task_modalcto">Assign User</a>
                                                                                             </div>

                                           

                                          </div>

                                           <div class="col-xs-12 col-sm-12">

                                                                    <div class="user_edit_wrapper">

                                                                        <div class="row">

                                                                            

                                                                              @foreach($con2 as $Con2)

                                                                              

                                                                                

                                                                             <?php

                                                                               $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id', $Con2->conid)->where('grc_project_condition_doc_assign.project_id',$Con2->project_id)->where('grc_project_condition_doc_assign.condtion_status',2)->where('grc_project_condition_doc_assign.state_id',$Con2->state_id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                                                                               

                                                                             ?>

                                                                            

                                                                            

                                                                            

                                                                            <div class="col-xs-12 col-sm-8">

                                                                                <div class="custom_checkbox">

                                                                                    <input class="styled-checkbox getval" data-s="{{$Con2->document_statement}}" data-userid="{{$selected_user_doc->user_id??$Con2->userId}}" id="checkbox_{{$Con2->id}}" type="checkbox" name="checkExp[]" value="{{$Con2->conid}}">

                                                                                    <label for="checkbox_1" class="fw-500"> @if(strlen($Con2->document_statement) > 85)

                                                                                    

                                                                                    {{substr($Con2->document_statement,0,85)}}...

                                                                                    

                                                                                    @else

                                                                                    

                                                                                    {{$Con2->document_statement}}

                                                                                    

                                                                                    @endif</label>

                                                                                </div>



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_2" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_2">The project proponent shall ensure that stack height is 6 m more than highest tower.</label>-->

                                                                                <!--</div>-->



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_3" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_3">Vertical fenestration shall not exceed 60% of total wall area.</label>-->

                                                                                <!--</div>-->



                                                                                <!--<div class="custom_checkbox">-->

                                                                                <!--    <input class="styled-checkbox" id="checkbox_4" type="checkbox" value="value1">-->

                                                                                <!--    <label for="checkbox_4">The project proponent shall ensure that structural stability to withstand earthquake of mag 8.5 on Richter scale</label>-->

                                                                                <!--</div>-->

                                                                            </div>



                                                                            <div class="col-xs-12 col-sm-4">

                                                                                <div class="users_list">

                                                                                    <ul>

                                                                                        <li class="fw-500">

                                                                                            

                                                                                            

                                                                                              @if(!empty($selected_user_doc))

                                                                                            

                                                                                            

                                                                                              {{$selected_user_doc->first_name}} {{$selected_user_doc->last_name}}

                                                                                            

                                                                                            @else

                                                                                            

                                                                                         Not Assign

                                                                                            

                                                                                            

                                                                                            @endif

                                                                                            

                                                                                        </li>

                                                                                        <!--<li>-->

                                                                                        <!--    Flora Hypas-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                        <!--<li>-->

                                                                                        <!--    Lucy Howaqrd-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                        <!--<li>-->

                                                                                        <!--    Lucy Howaqrd-->

                                                                                        <!--    <span><img src="assets/images/edit_icon.png" alt="" title=""></span>-->

                                                                                        <!--</li>-->

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                            

                                                                            

                                                                                                                         <div class="modal fade add_compliance" id="edit_task_modalcto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/edit-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     <div class="col-xs-12 col-sm-6">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Action</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-6" >

                        <input type="text" name="compliance"  class="form-control show" value="" placeholder="Enter Compliance Condition">

                         <input type="hidden" name="type" id="compliance" class="form-control compliance" > 

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <select class="form-control selecteduser" name="userid" required>
                        <option value="">Select Option </option>
                            @foreach($userlist as $ul)

                            <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                          @endforeach

                        </select>

                    

                     </div>

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="submit" class="sumit_compl" value="Save">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>





 <div class="modal fade add_compliance" id="arrange_task_modalcto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">User Assign</h5>
            <a href="#" class="assign_single_btn align-right" data-toggle="modal" data-target="#assign_task_modalcto">Sellect All</a>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding comliance_rearrange_order">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/Project-assignuser/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="doc_type" value="CTO">

                  





                  <?php

                 

                

                 $sected_user = array();

                $selected_user = DB::table('grc_project_condition_doc_assign')->where('doc_type', $Con2->doc_type)->where('project_id',$Con2->project_id)->where('condtion_status',1)->where('state_id',$Con2->state_id)->get();

                if(!empty( $selected_user)){

                   foreach($selected_user as $selected_users){

                    $sected_user[] = $selected_users->user_id??0;

                   }

                }



               

                ?>

                 

                 @php($i = 1)

                 @if(!empty($project_condition_cto))

                 @foreach($project_condition_cto as $key =>  $re)

                    <div class="row">

                       <div class="col-xs-12 col-sm-1">

                          <p>{{$i++}}</p>

                       </div>

                       <div class="col-xs-12 col-sm-5">

                         {{$re->document}}

                         <input type="hidden" name="document[]" id=""  value="{{$re->document}}">

                       

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{$re->condition_no}}" required>

                       </div>

                       

                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->id}}">

                      

                       <div class="col-xs-12 col-sm-2">

                          <select class="form-control" name="username[]" required>

                             <option value="">Option Select</option>

                          @foreach($userlist as $ul)

                          <option value="{{$ul->id}}"  @if(!empty($sected_user)) @if(in_array($ul->id,$sected_user)) selected  @endif @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                           @endforeach

                            

                          </select>

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="date" name="timeFrame[]"  value="{{ $selected_user[$key]->last_date_task??''}}" class="form-control" placeholder="Enter Time-frame"  required>

                       </div>

                    </div>

                   @endforeach



             

               @endif




                       <div class="container text-center">
    
     <table class="table table-bordered pagin-table">
        <thead>
            <tr>
                <th width="50px">S.No</th>
                <th class="text-center">Condition</th>
                <!--<th>Order</th>-->
                 <th class="text-center">Users</th>
                 <th class="text-center">Last Date</th>
                
            </tr>
        </thead>
        <tbody>
       

                  <?php 

                  

                  

                  

         

                  $ReData = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.doc_type',$Con2->doc_type)->where('grc_project_condition_doc.project_id',$id)->orderBy('grc_project_condition_doc.condition_number','ASC')->get();?>

                  <div class="single_row">

                  @foreach($ReData as $k =>  $re)



                  <?php

                  

                        $selected_user_doc = DB::table('grc_project_condition_doc_assign')->where('doc_id', $re->conid)->first();

               

     

                  

                  ?>
                  
                  
                 <tr onmousedown="myFunctionCTO(this)">
              <td > <span class="myFunctionCTO" > {{$i++}}</span></td>
              <td class="text-left">
                          {{$re->document_statement}}

                          <input type="hidden" name="document[]" id=""  value="{{$re->document_statement}}">
                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">

               </td>
              <!--<td>  -->
                <!--<input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control check_order" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$ky+1}}" required>-->
               
              <!--</td>-->
              <td style="width:200px;">  
              <select class="form-control" name="username[]" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif   @else  @if($ul->id == $re->user_id??0) selected @endif     @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                              </select>
                              </td>
              <td>   <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{ $selected_user_doc->last_date_task??''}}" required>
              </td>
            </tr>

                   

                    @endforeach



                    @if(count($ReData)==0)

                    <tr>

                           <td colspan = '8' align = 'center'> <b> No Data Found</b>

                           </td>

                        </tr>

                @endif
                
                </tbody>
                  </table>



                  </div>

               

                  <div class="col-xs-12 col-sm-12">

                     <input type="submit" name="addCompliance" class="sumit_compl" value="Save">

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

                                                                            

                                                                            @endforeach

                                                                            

                                                                            

                                                                        </div>

                                                                    </div>

                                                                </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>


<div class="modal fade" id="assign_task_modalcto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="assignAllCTO" method="post" action="{{URL::to('/Project-assignuser-indiviable/'.$id)}}">
  <div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <select class="form-control" name="username" required>
                            <option value="">Select Option </option>
                             @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                           </select>
  </div>
  <input type="hidden" name="stage" value="CTO">
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="Date" class="form-control" name="endDate" onchange="getDatetoCheck(this.value,'CTO','{{$id}}')"  required>
  <span id="CTO_error"></span>
  </div>

  <button  id="CTO_submit" type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>


                           <div class="card">

                              <div class="card-header" id="headingThree">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                    CTE 

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                    <div class="selected_condition">

                                         <label class="switch">

                                                       <input type="checkbox" data-con="CTE" class="chebox_true1" name="" @if($projectshow->project_stage =='CTE') checked    @endif ><span class="slider round"></span>

                                                                                                          </label>

                                       <!--<div class="custom_checkbox">-->

                                       <!--   <input class="styled-checkbox allchecked" id="checkbox_103" type="checkbox" value="value1">-->

                                       <!--   <label for="checkbox_103"></label>-->

                                       <!--</div>-->

                                    </div>

                                 </h2>

                              </div>

                              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                       <div class="row">

                                          <div class="col-xs-12 col-sm-8">

                                             <div class="edit_del_btns update_delete_btn">

                                                <a href="#" data-toggle="modal" data-target="#new_task_modalcte">New</a>

                                                <a href="#" data-toggle="modal" data-target="#edit_task_modalcte" class="editclass getedit">Edit</a>

                                                <a href="#" class="showss">Delete</a>

                                                <!-- <a href="#" data-toggle="modal" data-target="#arrange_task_modal">Assign User</a> -->

                                             </div>

                                            

                                            

                                          </div>

                                          <div class="col-xs-12 col-sm-4">

                                             <div class="compliance_user_box">

                                                <h4>

                                                   <img src="assets/images/user.png" alt="" title="">

                                                   User

                                                </h4>

                                                <a href="#" class="assign_user_btn" data-toggle="modal" data-target="#arrange_task_modalcte">Assign User</a>
                                                

                                             </div>

                                            <!--  <div class="users_list">

                                                <ul>

                                                 @foreach($userlist as $ul)

                                                   <li>

                                                      {{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})

                                                      <span><img src="assets/images/edit_icon.png" alt="" title=""></span>

                                                   </li>

                                                   @endforeach

                                                </ul>

                                             </div> -->

                                          </div>

                                           <div class="col-xs-12 col-sm-12">

                                                                    <div class="user_edit_wrapper">

                                                                        <div class="row">





                                                                             @foreach($con3 as $Con3)

                                                                             

                                                                             <?php

                                                                                $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id', $Con3->conid)->where('grc_project_condition_doc_assign.project_id',$Con3->project_id)->where('grc_project_condition_doc_assign.state_id',$Con3->state_id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                                                                               

                                                                             ?>

                                                                            <div class="col-xs-12 col-sm-8">

                                                                                <div class="custom_checkbox">

                                                                                    <input  class="styled-checkbox getval" data-s="{{$Con3->document_statement}}" data-userid="{{$selected_user_doc->user_id??$Con3->userId}}" id="checkbox_{{$Con3->id}}" type="checkbox" name="checkExp[]" value="{{$Con3->conid}}">

                                                                                    <label for="checkbox_1" class="fw-500">   @if(strlen($Con3->document_statement) > 85)

                                                                                    

                                                                                    {{substr($Con3->document_statement,0,85)}}...

                                                                                    

                                                                                    @else

                                                                                    

                                                                                    {{$Con3->document_statement}}

                                                                                    

                                                                                    @endif</label>

                                                                                </div>



                                                                               

                                                                            </div>



                                                                            <div class="col-xs-12 col-sm-4">

                                                                                <div class="users_list">

                                                                                    <ul>

                                                                                        <li class="fw-500">

                                                                                            

                                                                                             @if(!empty($selected_user_doc))

                                                                                            

                                                                                            

                                                                                              {{$selected_user_doc->first_name}} {{$selected_user_doc->last_name}}

                                                                                            

                                                                                            @else

                                                                                            

                                                                                            Not Assign

                                                                                            

                                                                                            

                                                                                            @endif

                                                                                            

                                                                                        </li>

                                                                                        

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                        

                                                                                                                     <div class="modal fade add_compliance" id="edit_task_modalcte" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/edit-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     <div class="col-xs-12 col-sm-6">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Action</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-6" >

                        <input type="text" name="compliance"  class="form-control show" value="" placeholder="Enter Compliance Condition">

                         <input type="hidden" name="type" id="compliance" class="form-control compliance" > 

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <select class="form-control selecteduser" name="userid" required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

<option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif  @else  @if($ul->id == $re->user_id??0) selected @endif      @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                             @endforeach

                        </select>

                    

                     </div>

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="submit" class="sumit_compl" value="Save">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>





<div class="modal fade add_compliance" id="arrange_task_modalcte" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">User Assign</h5>
             <a href="#" class="assign_single_btn align-right" data-toggle="modal" data-target="#assign_task_modalcte">Sellect All</a>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding comliance_rearrange_order">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/Project-assignuser/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="doc_type" value="CTE">

                   <table class="table table-bordered pagin-table">
        <thead>
            <tr>
                <th width="50px">S.No</th>
                <th class="text-center">Condition</th>
                <!--<th>Order</th>-->
                 <th class="text-center">Users</th>
                 <th class="text-center">Last Date</th>
                
            </tr>
        </thead>
        <tbody>

                 

                

                  <?php

                $sected_user = array();

                $selected_user = DB::table('grc_project_condition_doc_assign')->where('doc_type', $Con3->doc_type)->where('project_id',$Con3->project_id)->where('condtion_status',1)->where('state_id',$Con3->state_id)->get();

                if(!empty( $selected_user)){

                   foreach($selected_user as $selected_users){

                    $sected_user[] = $selected_users->user_id??0;

                   }

                }



               

                ?>

                 

                 @php($i = 1)

                 @if(!empty($project_condition_cte))

                 @foreach($project_condition_cte as $key =>  $re)

                    <div class="row">

                       <div class="col-xs-12 col-sm-1">

                          <p>{{$i++}}</p>

                       </div>

                       <div class="col-xs-12 col-sm-5">

                         {{$re->document}}

                         <input type="hidden" name="document[]" id=""  value="{{$re->document}}">

                       

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{$re->condition_no}}" required>

                       </div>

                       

                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->id}}">

                      

                       <div class="col-xs-12 col-sm-2">

                          <select class="form-control" name="username[]" required>
                           <option value="">Select Option </option>

                          @foreach($userlist as $ul)

                          <option value="{{$ul->id}}" @if(!empty($selected_user_doc[$k]->user_id)) @if($ul->id == $selected_user_doc[$k]->user_id??0) selected @endif  @else  @if($ul->id == $re->user_id??0) selected @endif      @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                           @endforeach

                            

                          </select>

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="date" name="timeFrame[]"  value="{{ $selected_user[$key]->last_date_task??''}}" class="form-control" placeholder="Enter Time-frame"  required>

                       </div>

                    </div>

                   @endforeach



             

               @endif





       

                  <?php 

                  

                  

               

          

                  $ReData = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.doc_type',$Con3->doc_type)->where('grc_project_condition_doc.project_id',$id)->orderBy('grc_project_condition_doc.condition_number','ASC')->get();?>

                  <div class="single_row">

                  @foreach($ReData as $k =>  $re)



                  <?php

                  

                      

               $selected_user_doc = DB::table('grc_project_condition_doc_assign')->where('doc_id',$re->id)->first();

              

                  

                  ?>

                 <tr onmousedown="myFunctionCTE(this)">
              <td > <span class="changeOrderCTE" > {{$i++}}</span></td>
              <td class="text-left">
                          {{$re->document_statement}}

                          <input type="hidden" name="document[]" id=""  value="{{$re->document_statement}}">
                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">

               </td>
              <!--<td>  -->
                <!--<input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control check_order" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$ky+1}}" required>-->
               
              <!--</td>-->
              <td style="width:200px;">  
              <select class="form-control" name="username[]" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif   @else  @if($ul->id == $re->user_id??0) selected @endif     @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                              </select>
                              </td>
              <td>   <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{ $selected_user_doc->last_date_task??''}}" required>
              </td>
            </tr>


                    @endforeach



                    @if(count($ReData)==0)

                    <tr>

                           <td colspan = '8' align = 'center'> <b> No Data Found</b>

                           </td>

                        </tr>

                @endif
                
                </tbody>
                  </table>

                  </div>

               

                  <div class="col-xs-12 col-sm-12">

                     <input type="submit" name="addCompliance" class="sumit_compl" value="Save">

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

                                                                        

                                                                        @endforeach

                                                                    </div>

                                                                </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>



    <div class="modal fade" id="assign_task_modalcte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="assignAllCTE" method="post" action="{{URL::to('/Project-assignuser-indiviable/'.$id)}}">
  <div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <select class="form-control" name="username" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                           </select>
  </div>
  <input type="hidden" name="stage" value="CTE">
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="Date" class="form-control" name="endDate" onchange="getDatetoCheck(this.value,'CTE','{{$id}}')"  required>
  <span id="CTE_error"></span>
  </div>

  <button  id="CTE_submit" type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

                           <div class="card">

                              <div class="card-header" id="headingFour">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">

                                    GB

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                    <div class="selected_condition">

                                         <label class="switch">

                                                     <input type="checkbox" data-con="GB" name="" class="chebox_true1" @if($projectshow->project_stage =='GB') checked    @endif ><span class="slider round"></span>

                                                                                                          </label>

                                       <!--<div class="custom_checkbox">-->

                                       <!--   <input class="styled-checkbox allchecked" id="checkbox_104" type="checkbox" value="value1">-->

                                       <!--   <label for="checkbox_104"></label>-->

                                       <!--</div>-->

                                    </div>

                                 </h2>

                              </div>

                              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                       <div class="row">

                                          <div class="col-xs-12 col-sm-8">

                                             <div class="edit_del_btns update_delete_btn">

                                                <a href="#" data-toggle="modal" data-target="#new_task_modalgb">New</a>

                                                <a href="#" data-toggle="modal" data-target="#edit_task_modalgb" class="editclass getedit">Edit</a>

                                                <a href="#" class="showss">Delete</a>

                                                <!-- <a href="#" data-toggle="modal" data-target="#arrange_task_modal">Assign User</a> -->

                                             </div>

                                           

                                           

                                          </div>

                                          <div class="col-xs-12 col-sm-4">

                                             <div class="compliance_user_box">

                                                <h4>

                                                   <img src="assets/images/user.png" alt="" title="">

                                                   User

                                                </h4>

                                                <a href="#" class="assign_user_btn" data-toggle="modal" data-target="#arrange_task_modalgb">Assign User</a>
                                                 

                                             </div>

                                             <!-- <div class="users_list">

                                                <ul>

                                                   @foreach($userlist as $ul)

                                                   <li>

                                                      {{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})

                                                      <span><img src="assets/images/edit_icon.png" alt="" title=""></span>

                                                   </li>

                                                   @endforeach

                                                </ul>

                                             </div> -->

                                          </div>

                                           <div class="col-xs-12 col-sm-12">

                                                                    <div class="user_edit_wrapper">

                                                                        <div class="row">

                                                                            

                                                                            @foreach($con4 as $Con4)

                                                                            <?php

                                                                            $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id', $Con4->conid)->where('grc_project_condition_doc_assign.project_id',$Con4->project_id)->where('grc_project_condition_doc_assign.state_id',$Con4->state_id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                                                                            

                                                                            ?>

                                                                            <div class="col-xs-12 col-sm-8">

                                                                                <div class="custom_checkbox">

                                                                                    <input class="styled-checkbox getval" name="checkExp[]" data-s="{{$Con4->document_statement}}" data-userid="{{$selected_user_doc->user_id??$Con4->userId}}" id="checkbox_{{$Con4->id}}" type="checkbox" value="{{$Con4->conid}}">

                                                                                    <label for="checkbox_1" class="fw-500">

                                                                                        

                                                                                        @if(strlen($Con4->document_statement) > 85)

                                                                                    

                                                                                    {{substr($Con4->document_statement,0,85)}}...

                                                                                    

                                                                                    @else

                                                                                    

                                                                                    {{$Con4->document_statement}}

                                                                                    

                                                                                    @endif

                                                                                    </label>

                                                                                </div>

 

                                                                            </div>



                                                                            <div class="col-xs-12 col-sm-4">

                                                                                <div class="users_list">

                                                                                    <ul>

                                                                                        <li>

                                                                                           

                                                                                        </li>

                                                                                        <li class="fw-500">

                                                                                            

                                                                                             @if(!empty($selected_user_doc))

                                                                                            

                                                                                            

                                                                                              {{$selected_user_doc->first_name}} {{$selected_user_doc->last_name}}

                                                                                            

                                                                                            @else

                                                                                            

                                                                                            Not Assign

                                                                                            

                                                                                            

                                                                                            @endif

                                                                                            

                                                                                            <span><img src="assets/images/edit_icon.png" alt="" title=""></span>

                                                                                        </li>

                                                                                       

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                            

                                                                                                                         <div class="modal fade add_compliance" id="edit_task_modalgb" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/edit-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     <div class="col-xs-12 col-sm-6">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Action</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-6" >

                        <input type="text" name="compliance"  class="form-control show" value="" placeholder="Enter Compliance Condition">

                         <input type="hidden" name="type" id="compliance" class="form-control compliance" > 

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <select class="form-control selecteduser" name="userid" required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                            <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                    

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <input type="submit" name="submit" class="sumit_compl add_compl_btn" value="Save">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>





 <div class="modal fade add_compliance" id="arrange_task_modalgb" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">User Assign</h5>
             <a href="#" class="assign_single_btn align-right" data-toggle="modal" data-target="#assign_task_modalgb">Sellect All</a>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding comliance_rearrange_order">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/Project-assignuser/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="doc_type" value="GB">
                       
                        <table class="table table-bordered pagin-table">
        <thead>
            <tr>
                <th width="50px">S.No</th>
                <th class="text-center">Condition</th>
                <!--<th>Order</th>-->
                 <th class="text-center">Users</th>
                 <th class="text-center">Last Date</th>
                
            </tr>
        </thead>
        <tbody>
            
                
                  <!--<div class="single_row">-->

                  <!--   <div class="row">-->

                  <!--      <div class="col-xs-12 col-sm-1">-->

                  <!--         <h5>S. No.</h5>-->

                  <!--      </div>-->

                  <!--      <div class="col-xs-12 col-sm-5">-->

                  <!--         <h5>Condition</h5>-->

                  <!--      </div>-->

                  <!--      <div class="col-xs-12 col-sm-2">-->

                  <!--         <h5>Display Order</h5>-->

                  <!--      </div>-->

                  <!--      <div class="col-xs-12 col-sm-2">-->

                  <!--         <h5>Users</h5>-->

                  <!--      </div>-->

                  <!--      <div class="col-xs-12 col-sm-2">-->

                  <!--         <h5>Task Last Date</h5>-->

                  <!--      </div>-->

                  <!--   </div>-->

                  <!--</div>-->





                  <?php

                $sected_user = array();

                $selected_user = DB::table('grc_project_condition_doc_assign')->where('doc_type', $Con4->doc_type)->where('project_id',$Con4->project_id)->where('condtion_status',1)->where('state_id',$Con4->state_id)->get();

                if(!empty( $selected_user)){

                   foreach($selected_user as $selected_users){

                    $sected_user[] = $selected_users->user_id??0;

                   }

                }



               

                ?>

                 

                 @php($i = 1)

                 @if(!empty($project_condition_gb))

                 @foreach($project_condition_gb as $key =>  $re)

                    <div class="row">

                       <div class="col-xs-12 col-sm-1">

                          <p>{{$i++}}</p>

                       </div>

                       <div class="col-xs-12 col-sm-5">

                         {{$re->document}}

                         <input type="hidden" name="document[]" id=""  value="{{$re->document}}">

                       

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{$re->condition_no}}" required>

                       </div>

                       

                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->id}}">

                      

                       <div class="col-xs-12 col-sm-2">

                          <select class="form-control" name="username[]" required>

                             <option value="">Option Select</option>

                          @foreach($userlist as $ul)

                          <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                           @endforeach

                            

                          </select>

                       </div>

                       <div class="col-xs-12 col-sm-2">

                          <input type="date" name="timeFrame[]"  value="{{ $selected_user[$key]->last_date_task??''}}" class="form-control" placeholder="Enter Time-frame"  required>

                       </div>

                    </div>

                   @endforeach



             

               @endif





       

                  <?php 

                  

                  

               

          

                  $ReData = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.doc_type',$Con4->doc_type)->where('grc_project_condition_doc.project_id',$id)->orderBy('grc_project_condition_doc.condition_number','ASC')->get();?>

                  <div class="single_row">

                  @foreach($ReData as $k =>  $re)



                  <?php

                  

                        

               $selected_user_doc = DB::table('grc_project_condition_doc_assign')->where('doc_id',$re->conid)->first();

            

                  

                  ?>
                  
                 <tr onmousedown="myFunctionGB(this)">
              <td > <span class="changeOrderGB" > {{$i++}}</span></td>
              <td class="text-left">
                          {{$re->document_statement}}

                          <input type="hidden" name="document[]" id=""  value="{{$re->document_statement}}">
                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">

               </td>
              <!--<td>  -->
                <!--<input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control check_order" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$ky+1}}" required>-->
               
              <!--</td>-->
              <td style="width:200px;">  
              <select class="form-control" name="username[]" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif   @else  @if($ul->id == $re->user_id??0) selected @endif     @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                              </select>
                              </td>
              <td>   <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{ $selected_user_doc->last_date_task??''}}" required>
              </td>
            </tr>
              


                     <!--<div class="row">-->

                     <!--   <div class="col-xs-12 col-sm-1">-->

                     <!--      <p>1</p>-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-5">-->

                     <!--     {{$re->document_statement}}-->

                     <!--     <input type="hidden" name="document[]" id=""  value="{{$re->document_statement}}">-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$k+1}}" required>-->

                     <!--   </div>-->

                        

                     <!--      <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">-->

                       

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <select class="form-control" name="username[]" required>-->
                     <!--       <option value="">Select Option </option>-->

                     <!--      @foreach($userlist as $ul)-->

                     <!--      <option value="{{$ul->id}}"  @if(!empty($selected_user_doc)) @if($selected_user_doc->user_id??0 == $ul->id) selected  @endif @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>-->

                     <!--       @endforeach-->

                             

                     <!--      </select>-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame"  value="{{ $selected_user_doc->last_date_task??''}}"  required>-->

                     <!--   </div>-->

                     <!--</div>-->

                    @endforeach



                    @if(count($ReData)==0)

                    <tr>

                           <td colspan = '8' align = 'center'> <b> No Data Found</b>

                           </td>

                        </tr>

                @endif


                  </tbody>
                  </table>


                 

                               

               

                  <div class="col-xs-12 col-sm-12">

                     <input type="submit" name="addCompliance" class="sumit_compl" value="Save">

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

        

                                                                            @endforeach

                                                                        </div>

                                                                        

                                                                        

                                                                    </div>

                                                                </div>

                                       </div>

                                    </div>

                                 </div>

                              </div>

                           </div>


<div class="modal fade" id="assign_task_modalgb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="assignAllGB" method="post" action="{{URL::to('/Project-assignuser-indiviable/'.$id)}}">
  <div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <select class="form-control" name="username" required>
                            <option value="">Select Option </option>
                           @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                           </select>
  </div>
  <input type="hidden" name="stage" value="GB">
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="Date" class="form-control" name="endDate" onchange="getDatetoCheck(this.value,'GB','{{$id}}')"  required>
  <span id="GB_error"></span>
  </div>

  <button  id="GB_submit" type="submit" class="btn btn-default">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>



                           <?php $newcon = DB::table('grc_project_additional_condition')->where('project_id',$id)->get();

                           

                               //echo"<pre>"; print_r($newcon); die('dfxgdfg');

                           ?>

                           @foreach($newcon as $newdata)

                           

                            

                           

                           <div class="card">

                              <div class="card-header" id="headingFive">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive{{$newdata->id}}" aria-expanded="false" aria-controls="collapseFive">

                                    {{$newdata->stage_name}}

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                    <div class="selected_condition">

                                     <label class="switch">

                                      <input type="checkbox" data-con="{{$newdata->stage_name}}" name="" class="chebox_true1" @if($projectshow->project_stage == $newdata->stage_name) checked    @endif ><span class="slider round"></span>

                                       </label>

                                    </div>

                                 </h2>

                              </div>

                              <div id="collapseFive{{$newdata->id}}" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                       <div class="row">

                                          <div class="col-xs-12 col-sm-8">

                                             <div class="edit_del_btns update_delete_btn">

                                                <a href="#" data-toggle="modal" data-target="#new_task_modal{{$newdata->id}}">New</a>

                                                <a href="#" data-toggle="modal" data-target="#edit_task_modal{{$newdata->id}}" class="editclass getedit">Edit</a>

                                                <a href="#" class="showss" id="del">Delete</a>

                                                <!-- <a href="#" data-toggle="modal" data-target="#arrange_task_modal">Assign User</a> -->

                                             </div>

                                                <?php $userlists = DB::table('grc_project_condition_doc')->select('*','grc_user.id as uid','grc_user.id as userId','grc_project_condition_doc.id as cid')->leftjoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')->where('doc_type',$newdata->stage_name)->select('grc_project_condition_doc.*','grc_project_condition_doc.id as cid')->get(); 



                                                   

                                                ?>

                                          

                                                    

                                          

                                          

     <div class="modal fade add_compliance" id="new_task_modal{{$newdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">New Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

               <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/add-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Condition No.</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Category</strong></p>

                     </div>

                      <div class="col-xs-12 col-sm-2">

                        <p><strong>Last Date</strong></p>

                     </div>

                  

                      <div class="col-xs-12 col-sm-2">

                        <input type="text" name="condition_no" onkeypress="preventNonNumericalInput(event)" class="form-control" placeholder="No." Required>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <input type="text" name="compliance" id="compliance" class="form-control" placeholder="Enter Compliance Condition" Required>

                         <input type="hidden" name="type" id="compliance" class="form-control" value="{{$newdata->stage_name}}"> 

                         <?php $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;?>

                          <input type="hidden" name="stateid" class="form-control" value="{{$stateid}}">

                           <input type="hidden" name="sectorid" class="form-control" value="{{$sectorid}}">

                     </div>

                       <div class="col-xs-12 col-sm-3">

                        <select class="form-control selecteduser" name="userid" Required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}">{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                     <select name="category" class="form-control" Required>

                            <option value="Generic">Generic</option>

                            <option value="Specific">Specific</option>

                         </select>

                      </div>

                      

                      

                       <div class="col-xs-12 col-sm-2">

                             <input type="date" name="timeFrame" id="timeFrame" class="form-control"  Required>

                                 </div>

                   

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="addCompliance" class="sumit_compl" value="Add">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>                                  

</div>

                                            @if(count($userlists) > 0)

                                           @foreach($userlists as $ncs)

                                           

                                           

                                            <?php

                                         $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id', $ncs->id)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->first();

                                         //dd($selected_user_doc);

                                                                                                                             

                                ?>

                                         

                                                                            

                                                                            







<div class="modal fade add_compliance" id="edit_task_modal{{$newdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/edit-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     <div class="col-xs-12 col-sm-6">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-4">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Action</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-6" >

                        <input type="text" name="compliance"  class="form-control show" value="" placeholder="Enter Compliance Condition">

                         <input type="hidden" name="type" id="compliance"  class="form-control compliance" > 

                     </div>

                     

                     <div class="col-xs-12 col-sm-4">

                        <select class="form-control selecteduser" id="listuser" name="userid" required>
                         <option value="">Select Option </option>

                          @foreach($userlist as $ul)

                           <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                    

                     </div>

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="submit" class="sumit_compl" value="Save">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>







<div class="row">

                                           <div class="col-xs-12 col-sm-8">

                                             <div class="custom_checkbox_{{$ncs->id??0}}">

                                                <input class="styled-checkbox getval" name="checkExp[]" data-s="{{$ncs->document_statement??''}}" data-userid="{{$selected_user_doc->user_id??$ncs->userId??0}}" type="checkbox" value="{{$ncs->cid??0}}" >

                                                <label for="checkbox_1">  

                                                                                        @if(!empty($ncs->document_statement) && strlen($ncs->document_statement) > 85)

                                                                                    

                                                                                    {{substr($ncs->document_statement,0,85)}}...

                                                                                    

                                                                                    @else

                                                                                    

                                                                                    {{$ncs->document_statement??''}}

                                                                                    

                                                                                    @endif</label>

                                             </div>

                                             </div>

                                                 <div class="col-xs-12 col-sm-4">

                                                                                <div class="users_list">

                                                                                    <ul>

                                                                                        <li>

                                                                                           

                                                                                        </li>

                                                                                        <li class="fw-500">

                                                                                            

                                                                                             

                                                                                            @if(!empty($selected_user_doc))

                                                                                            

                                                                                            

                                                                                              {{$selected_user_doc->first_name??''}} {{$selected_user_doc->last_name??''}}

                                                                                            

                                                                                            @else

                                                                                            

                                                                                           Not Assign

                                                                                            

                                                                                            

                                                                                            @endif

                                                                                            

                                                                                            <span><img src="assets/images/edit_icon.png" alt="" title=""></span>

                                                                                        </li>

                                                                                       

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                            

                                             @endforeach

                                             @endif

                                          </div>

                                         

                                          <div class="col-xs-12 col-sm-4">

                                             <div class="compliance_user_box">

                                                <h4>

                                                   <img src="assets/images/user.png" alt="" title="">

                                                   User

                                                </h4>

                                                



                                                <a href="#" class="assign_user_btn userass" data-toggle="modal" data-target="#arrange_task_modal{{$newdata->id}}" >Assign User</a>

                                                


                                             </div>



                                    

                                          </div>

                                       </div>

  



                                       

                                    </div>

                                 </div>

                              </div>

                           </div>









<div class="modal fade add_compliance" id="arrange_task_modal{{$newdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">User Assign</h5>
             <a href="#" class="assign_single_btn  userass align-right" data-toggle="modal" data-target="#assign_task_modal{{$newdata->id}}" >Sellect All</a>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding comliance_rearrange_order">

                 <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/Project-assignuser/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="doc_type" value="{{$newdata->stage_name}}">

                 <table class="table table-bordered pagin-table">
        <thead>
            <tr>
                <th width="50px">S.No</th>
                <th class="text-center">Condition</th>
                <!--<th>Order</th>-->
                 <th class="text-center">Users</th>
                 <th class="text-center">Last Date</th>
                
            </tr>
        </thead>
        <tbody>

                 

                  <?php 

                  

                   



                      $last = 1;           

                  $ReData = DB::table('grc_project_condition_doc')->select('*','grc_project_condition_doc.id as conid','grc_user.id as userId')->leftJoin('grc_user','grc_project_condition_doc.user_id','=','grc_user.id')

      ->where('grc_project_condition_doc.state_id',$stateid)->where('grc_project_condition_doc.sector_name',$sectorid)->where('grc_project_condition_doc.doc_type',$newdata->stage_name)->orderBy('grc_project_condition_doc.condition_number','ASC')->get();







      ?>

                  <div class="single_row">

                  @foreach($ReData as $k => $re)





                  <?php

                  



     $selected_user_doc = DB::table('grc_project_condition_doc_assign')->join('grc_user','grc_user.id','=','grc_project_condition_doc_assign.user_id')->where('grc_project_condition_doc_assign.doc_id',$re->conid)->select('grc_project_condition_doc_assign.*','grc_user.first_name','grc_user.last_name')->orderBy('grc_project_condition_doc_assign.condition_number','ASC')->first();

   

                  ?>
                  
                   <tr onmousedown="myFunction(this)">
              <td > <span class="changeOrder" > {{$last++}}</span></td>
                  
              <td class="text-left">
                           {{$re->document_statement}}

                          <input type="hidden" name="document[]" id="" value="{{$re->document_statement}}">
                          <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">

               </td>
              <!--<td>  -->
                <!--<input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control check_order" placeholder="Enter order" value="{{ $selected_user_doc->condition_number??$ky+1}}" required>-->
               
              <!--</td>-->
              <td style="width:200px">  
               <select class="form-control" name="username[]" required>

                             <option value="">Option Select</option>

                           @foreach($userlist as $ul)

                          <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif       @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                             

                           </select>

                              </td>
              <td>  
              
                           <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{$selected_user_doc->last_date_task??''}}">

              </td>
            </tr>


                     <!--<div class="row">-->

                     <!--   <div class="col-xs-12 col-sm-1">-->

                     <!--      <p>{{$last++}}</p>-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-5">-->

                     <!--     {{$re->document_statement}}-->

                     <!--     <input type="hidden" name="document[]" id="" value="{{$re->document_statement}}">-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <input type="text" name="order[]" onkeypress="preventNonNumericalInput(event)" id="" class="form-control" placeholder="Enter order" value="{{$selected_user_doc->condition_number??$k+1}}" required>-->

                     <!--   </div>-->

                        

                     <!--      <input type="hidden" name="conditionrealid[]" id="" class="form-control" placeholder="Enter order" value="{{$re->conid}}">-->

                       

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <select class="form-control" name="username[]" required>-->

                     <!--        <option value="">Option Select</option>-->

                     <!--      @foreach($userlist as $ul)-->

                     <!--     <option value="{{$ul->id}}" @if(!empty($selected_user_doc->user_id)) @if($ul->id == $selected_user_doc->user_id??0) selected @endif       @endif>{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>-->

                     <!--       @endforeach-->

                             

                     <!--      </select>-->

                     <!--   </div>-->

                     <!--   <div class="col-xs-12 col-sm-2">-->

                     <!--      <input type="date" name="timeFrame[]" class="form-control" placeholder="Enter Time-frame" value="{{$selected_user_doc->last_date_task??''}}">-->

                     <!--   </div>-->

                     <!--</div>-->

                    @endforeach



                    @if(count($ReData)==0)

                    <tr>

                           <td colspan = '8' align = 'center'> <b> No Data Found</b>

                           </td>

                        </tr>

                @endif

                   </tbody>
                  </table>

                  </div>

               

                  <div class="col-xs-12 col-sm-12">

                     <input type="submit" name="addCompliance" class="sumit_compl" value="Save">

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>


 <div class="modal fade" id="assign_task_modal{{$newdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="assignAll" method="post" action="{{URL::to('/Project-assignuser-indiviable/'.$id)}}">
  <div class="form-group">
    <label for="exampleInputEmail1">User</label>
    <select class="form-control" name="username" required>
                            <option value="">Select Option </option>
                            @foreach($userlist as $ul)

                          <option value="{{$ul->id}}" >{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach
                           </select>
  </div>
  
  <input type="hidden" name="stage" value="{{$newdata->stage_name}}">
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="Date" class="form-control" name="endDate" onchange="getDatetoCheck(this.value,'{{str_replace(' ','',$newdata->stage_name)}}','{{$id}}')"  required>
  <span id="{{str_replace(' ','',$newdata->stage_name)}}_error"></span>
  </div>

  <button  id="{{str_replace(' ','',$newdata->stage_name)}}_submit" type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

                           @endforeach


                          

                           <div class="card">

                              <div class="card-header" id="headingSix">

                                 <h2 class="mb-0">

                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">

                                    Add Condition

                                    <span class="plus_icon">+</span>

                                    <span class="minus_icon">-</span>

                                    </button>

                                 </h2>

                              </div>

                              <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">

                                 <div class="card-body">

                                    <div class="inner_body">

                                        <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/Project-additional-condition/'.$id)}}"  enctype="multipart/form-data">

                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                          <div class="row">

                                             <div class="col-xs-12 col-sm-6">

                                       

                                       <div class="condition_add">

                                       <div class="row">

                                       <div class="col-xs-12 col-sm-9">

                                       <div class="form-group">

                                       <input type="text" name="addCondition" id="addCondition" class="form-control condition_box" placeholder="Enter Condition">

                                       </div>

                                       </div>

                                       <div class="col-xs-12 col-sm-3">

                                       <input type="submit" name="saveCondition" id="saveCondition" value="Save" class="save_condition">

                                       </div>

                                       </div>

                                       </div>

                                       </form>

                                       </div>

                                       </div>

                                       </form>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>

                  <div class="col-12">

                     <div class="project_details_condition">

                        <div class="details_show">

                           <!--<p><img src="assets/images/idea_icon.png" alt="" title=""> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod aliqua.</p>-->

                           <!--<p><img src="assets/images/idea_icon.png" alt="" title=""> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod aliqua lorem ipsum .</p>-->

                           <!--<p><img src="assets/images/idea_icon.png" alt="" title=""> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod aliqua lorem ipsum lorol item minis.</p>-->

                        </div>

                     </div>

                  </div>

                  <div class="col-sm-12 text-center">

                     <a href="{{URL::to('/Project-list')}}" class="btn btn-primary">Back</a>

                  </div>

               </div>

            </div>

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

<!-- New Added Modal -->

<div class="modal fade add_compliance" id="new_task_modalec" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">New Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

            <div class="comliance_adding">

               <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/add-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Condition No.</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Category</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Last Date</strong></p>

                     </div>

                    

                      <div class="col-xs-12 col-sm-2">

                        <input type="text" onkeypress="preventNonNumericalInput(event)" name="condition_no"  class="form-control" placeholder="No." Required>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <input type="text" name="compliance" id="compliance" class="form-control" placeholder="Enter Compliance Condition" Required>

                         <input type="hidden" name="type" id="compliance" class="form-control" value="EC">

                         <?php $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;?>

                          <input type="hidden" name="stateid" class="form-control" value="{{$stateid}}">

                           <input type="hidden" name="sectorid" class="form-control" value="{{$sectorid}}">

                     </div>

                       <div class="col-xs-12 col-sm-3">

                        <select class="form-control selecteduser" name="userid" Required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}">{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                     <select name="category" class="form-control" Required>

                            <option value="Generic">Generic</option>

                            <option value="Specific">Specific</option>

                         </select>

                      </div>

                      

                      

                             <div class="col-xs-12 col-sm-2">

                             <input type="date" name="timeFrame" id="timeFrame" class="form-control"  Required>

                                 </div>

                    

                     <div class="col-xs-12 col-sm-12 text-center m-t-10">

                        

                        <input type="submit" name="addCompliance" class="sumit_compl" value="Add">

                     

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>



<div class="modal fade add_compliance" id="new_task_modalcto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">New Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

             <div class="comliance_adding">

               <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/add-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Condition No.</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Category</strong></p>

                     </div>

                      <div class="col-xs-12 col-sm-2">

                        <p><strong>Last Date</strong></p>

                     </div>

                    

                      <div class="col-xs-12 col-sm-2">

                        <input type="text" name="condition_no" onkeypress="preventNonNumericalInput(event)"  class="form-control" placeholder="No." Required>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <input type="text" name="compliance" id="compliance" class="form-control" placeholder="Enter Compliance Condition" Required>

                         <input type="hidden" name="type" id="compliance" class="form-control" value="CTO">

                         <?php $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;?>

                          <input type="hidden" name="stateid" class="form-control" value="{{$stateid}}">

                           <input type="hidden" name="sectorid" class="form-control" value="{{$sectorid}}">

                     </div>

                       <div class="col-xs-12 col-sm-3">

                        <select class="form-control selecteduser" name="userid" Required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}">{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                     <select name="category" class="form-control" Required>

                            <option value="Generic">Generic</option>

                            <option value="Specific">Specific</option>

                         </select>

                      </div>

                   

                   

                       <div class="col-xs-12 col-sm-2">

                             <input type="date" name="timeFrame" id="timeFrame" class="form-control"  Required>

                                 </div>

                   

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="addCompliance" class="sumit_compl" value="Add">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

<div class="modal fade add_compliance" id="new_task_modalcte" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">New Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

             <div class="comliance_adding">

               <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/add-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Condition No.</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Category</strong></p>

                     </div>

                     

                       <div class="col-xs-12 col-sm-2">

                        <p><strong>Last Date</strong></p>

                     </div>

                     

                    

                      <div class="col-xs-12 col-sm-2">

                        <input type="text" name="condition_no" onkeypress="preventNonNumericalInput(event)"  class="form-control" placeholder="No." Required>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <input type="text" name="compliance" id="compliance" class="form-control" placeholder="Enter Compliance Condition" Required>

                         <input type="hidden" name="type" id="compliance" class="form-control" value="CTE">

                         <?php $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;?>

                          <input type="hidden" name="stateid" class="form-control" value="{{$stateid}}">

                           <input type="hidden" name="sectorid" class="form-control" value="{{$sectorid}}">

                     </div>

                       <div class="col-xs-12 col-sm-3">

                        <select class="form-control selecteduser" name="userid" Required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}">{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                     <select name="category" class="form-control" Required>

                            <option value="Generic">Generic</option>

                            <option value="Specific">Specific</option>

                         </select>

                      </div>

                      

                      

                       <div class="col-xs-12 col-sm-2">

                             <input type="date" name="timeFrame" id="timeFrame" class="form-control"  Required>

                                 </div>

                   

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="addCompliance" class="sumit_compl" value="Add">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

<div class="modal fade add_compliance" id="new_task_modalgb" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h5 class="modal-title" id="exampleModalCenterTitle">New Condition</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

            </button>

         </div>

         <div class="modal-body">

              <div class="comliance_adding">

               <form class="court-info-form"  role="form" method="POST" action="{{URL::to('/add-condition/'.$id)}}"  enctype="multipart/form-data">

               <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="row">

                     

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Condition No.</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Condition</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <p><strong>Users</strong></p>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                        <p><strong>Category</strong></p>

                     </div>

                     

                     

                       <div class="col-xs-12 col-sm-2">

                        <p><strong>Last Date</strong></p>

                     </div>

                     

                   

                      <div class="col-xs-12 col-sm-2">

                        <input type="text" name="condition_no" onkeypress="preventNonNumericalInput(event)"  class="form-control" placeholder="No."  Required>

                     </div>

                     <div class="col-xs-12 col-sm-3">

                        <input type="text" name="compliance" id="compliance" class="form-control" placeholder="Enter Compliance Condition"  Required>

                         <input type="hidden" name="type" id="compliance" class="form-control" value="GB">

                         <?php $projectDet = DB::table('grc_project')->where('id',$id)

                    ->first();

                  $stateid = $projectDet->state;

                  $sectorid = $projectDet->sector;?>

                          <input type="hidden" name="stateid" class="form-control" value="{{$stateid}}">

                           <input type="hidden" name="sectorid" class="form-control" value="{{$sectorid}}">

                     </div>

                       <div class="col-xs-12 col-sm-3">

                        <select class="form-control selecteduser" name="userid"  Required>
                         <option value="">Select Option </option>

                            @foreach($userlist as $ul)

                           <option value="{{$ul->id}}">{{$ul->first_name}} {{$ul->last_name}} (EMP-{{$ul->employee_id}})</option>

                            @endforeach

                        </select>

                     </div>

                     <div class="col-xs-12 col-sm-2">

                     <select name="category" class="form-control"  Required>

                            <option value="Generic">Generic</option>

                            <option value="Specific">Specific</option>

                         </select>

                      </div>

                     

                       <div class="col-xs-12 col-sm-2">

                             <input type="date" name="timeFrame" id="timeFrame" class="form-control"  Required>

                                 </div>

                     <div class="col-xs-12 col-sm-12 text-center">

                        <input type="submit" name="addCompliance" class="sumit_compl" value="Add">

                     </div>

                  </div>

               </form>

            </div>

         </div>

      </div>

   </div>

</div>

<!-- End New Added Modal -->

<!-- Edit Added Modal -->



@stop

@section('extra_js')  

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> 
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">-->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">  -->
    
    <script type="text/javascript">
  $('tbody').sortable();
</script>
<script>

function myFunctionEC(input){
    $('.changeOrderEC').each(function(i, obj) {
    $(this).text(i+1);
});
}

function myFunctionCTO(input){
    $('.changeOrderCTO').each(function(i, obj) {
    $(this).text(i+1);
});
}

function myFunctionCTE(input){
    $('.changeOrderCTE').each(function(i, obj) {
    $(this).text(i+1);
});
}

function myFunctionGB(input){
    $('.changeOrderGB').each(function(i, obj) {
    $(this).text(i+1);
});
}

function myFunction(input){
    $('.changeOrder').each(function(i, obj) {
    $(this).text(i+1);
});
}








function check_order(){

 var arr = [];

  var err = [];

  var counter = 0;

$('.check_order').each(function(){

    var value = $(this).val();

    if (arr.indexOf(value) == -1){

        arr.push(value);

    }else{

        $(this).addClass("duplicate");

        

        return false;

    }

     

   counter++;

        

});





console.log(arr);

console.log(counter);





// if(err.length == 0){

//  $("#ec").submit();    

// }









}



   var project_id = '{{$id}}';

  $('.chebox_true1').change(function() {

     

            if($(this).is(":checked")) {

                $(this).prop('checked', true);

              var condition = $(this).data('con');



           $.ajax({

   

             url:siteurl+'/public/project-type/'+condition+'/'+project_id,

   

             type: "GET",

   

             cache: false,

   

             dataType: 'json',

   

             success: function (response) {

                

             }

        })



                $(this).parents(".card").siblings().find(".chebox_true1").prop('checked', false);

            }

        });

        

             $('.getval').change(function() {

     

            if($(this).is(":checked")) {

                $(this).prop('checked', true);

                $(this).parents().siblings().find(".getval").prop('checked', false);

            }

        });

        

   $(function () {

   var listval = [];

        $('input[name="checkExp[]"]').bind('click', function () {

      

            

            console.log(listval);

            $('.details_show').html('<p>'+$(this).data('s')+'</p>');

        });

    });    

        

        $(document).on('click','.getedit',function(){

           

          

           $('input[name="checkExp[]"]:checked').each(function() {

   //console.log(this.value);

  var userid =  $(this).data('userid');
  var TaskID =  $(this).val();
   $('.show').val($(this).data('s'));
  $('.compliance').val(TaskID);
   

   vals = []

var sel = document.querySelector("select");

for (var i=0, n=sel.options.length;i<n;i++) { // looping over the options

  if (sel.options[i].value) vals.push(sel.options[i].value);



}

 console.log(userid);

 



 

 $(".selecteduser > option").each(function() {

     console.log($(this).val());

         if($(this).val() == userid){

            $('.selecteduser').val(userid).attr("selected"); 

         }



      });





 

});



            

         

        });

     function getDatetoCheck(selectdate,type,project_id){
          console.log(selectdate);
           console.log(type);
           $.ajax({
             url:siteurl+'/public/checkProjectDate/'+selectdate+'/'+project_id,
             type: "GET",
             cache: false,
             dataType: 'json',
             success: function (response) {
            
             if(response.status == 200){
              $('#'+type+'_error').text(response.msg).css("color", "green");
              $('#'+type+'_submit').removeAttr("disabled");
              $('#'+type+'_submit').removeClass("btn btn-danger");
               $('#'+type+'_submit').addClass("btn btn-primary");
              $('[name="endDate"]').removeClass("error");
              $('#endDate-error').hide();
              endDate
             }else{
             $('#'+type+'_error').text(response.msg).css("color", "red");
             $('#'+type+'_submit').attr("disabled", "disabled"); 
             $('#'+type+'_submit').removeClass("btn btn-primary");
              $('#'+type+'_submit').addClass("btn btn-danger");
             }
                

             }

        })

      }

                    

  $(document).ready(function() {
  $("#assginAllEC").validate({
    rules: {
      username : {
        required: true
       
      },
       endDate : {
        required: true
      
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
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
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

  $(document).ready(function() {
  $("#assignAllCTO").validate({
    rules: {
      username : {
        required: true
       
      },
       endDate : {
        required: true
       
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
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
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

  $(document).ready(function() {
  $("#assignAllCTE").validate({
    rules: {
      username : {
        required: true
       
      },
       endDate : {
        required: true
        
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
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
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



  $(document).ready(function() {
  $("#assignAllGB").validate({
    rules: {
      username : {
        required: true
       
      },
       endDate : {
        required: true
        
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
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
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


 $(document).ready(function() {
  $("#assignAll").validate({
    rules: {
      username : {
        required: true
     
      },
       endDate : {
        required: true
       
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
      fname: {
        minlength: "First Name should be at least 3 characters",
        maxlength: "First Name should be at Max 60 characters",
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

@stop