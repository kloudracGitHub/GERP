@extends('superadmin_layout')
   @section('content') 
       <div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
               <div class="container-fluid">
                  <div class="page-title-box">
                     <div class="row align-items-center bredcrum-style">
                        <div class="col-sm-6">
                           <h4 class="page-title">Documents</h4>
                        </div>
                        <div class="col-sm-6">
                           <div class="compliance_condition">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12">
                                    <!--<form>-->
                                    <!--   <div class="compliance_search">-->
                                    <!--      <img src="assets/images/search_icon.png" alt="" title="">-->
                                    <!--      <input type="text" name="Compliancesearch" id="Compliancesearch" class="form-control compliance_box" autofill="false" placeholder="Search">-->
                                    <!--   </div>-->
                                    <!--</form>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="project_details">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                           @if(session::has('message'))

                           <div class="alert alert-warning alert-dismissible fade show" role="alert">
  {{session::get('message')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>


                           @endif
                           <div class="documents_wrapper">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-7">
                                    <h3><img src="assets/images/master_database.png" alt="" title=""> Masterdata base</h3>
                                 </div>
                                 <div class="col-xs-12 col-sm-5">
                                    <h4></h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end row -->
                     <div class="row">
                        <div class="col-xs-12 col-sm-8">
                           <div class="">
                              <?php $statelist = DB::table('alm_states')->where('country_id',101)->select('*','alm_states.id as stateid')->get();?>
                              <div class="document_sector_wrapper">
                                 <select class="inside_state_sector" id="statesI">
                                    
                                    <option value="0">State</option>
                                    @foreach($statelist as $state)
                                    <option value="{{$state->stateid}}">{{$state->name}}</option>
                                    @endforeach
                                 </select>
                                 <?php $sectorlist = DB::table('grc_sector')->select('*')->get();?>
                                 <select class="inside_state_sector" id="sectorI">
                                    <option value="0">Sector</option>
                                    @foreach($sectorlist as $sector)
                                    <option value="{{$sector->id}}">{{$sector->sector_name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="project_details_collapse">
                                 <div class="inside_collapse document_inside_collapse">
                                    <div class="accordion" id="accordionExample">
                                       <div class="card">
                                          <div class="card-header" id="headingOne">
                                             <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                EC Conditions
                                                <span class="plus_icon">+</span>
                                                <span class="minus_icon">-</span>
                                                </button>
                                             </h2>
                                          </div>
                                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="inner_body">
                                                   <div class="row">
                                                     

                                                      <div class="col-xs-12 col-sm-12 ec" >
                                                      <!-- @foreach($docData1 as $ECData)
                                                         <div class="custom_checkbox ">
                                                            
                                                            <label for="checkbox_1"><span class="m-r-10 font-600">{{$ECData->condition_no}} .</span>{{$ECData->document}}</label>

                                                         </div>
                                                     @endforeach -->
                                                       
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="card">
                                          <div class="card-header" id="headingTwo">
                                             <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                CTO Conditions
                                                <span class="plus_icon">+</span>
                                                <span class="minus_icon">-</span>
                                                </button>
                                             </h2>
                                          </div>
                                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="inner_body">
                                                   <div class="row">
                                                     
                                                      <div class="col-xs-12 col-sm-12 cto">
                                                         <!-- @foreach($docData2 as $ECData)
                                                         <div class="custom_checkbox ">
                                                            
                                                           <label for="checkbox_1"><span class="m-r-10 font-600"> {{$ECData->condition_no}} .</span>{{$ECData->document}}</label>

                                                         </div>
                                                           @endforeach -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="card">
                                          <div class="card-header" id="headingThree">
                                             <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                CTE Conditions
                                                <span class="plus_icon">+</span>
                                                <span class="minus_icon">-</span>
                                                </button>
                                             </h2>
                                          </div>
                                          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="inner_body">
                                                  
                                                   <div class="row">
                                                      <div class="col-xs-12 col-sm-12 cte">
                                                         <div class="custom_checkbox">
                                                             <!-- @foreach($docData3 as $ECData)
                                                         <div class="custom_checkbox " >
                                                            
                                                            <label for="checkbox_1"><span class="m-r-10 font-600">{{$ECData->condition_no}} .</span>{{$ECData->document}}</label>

                                                         </div>
                                                           @endforeach -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                   
                                       </div>
                                       <div class="card">
                                          <div class="card-header" id="headingFour">
                                             <h2 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                GB Conditions
                                                <span class="plus_icon">+</span>
                                                <span class="minus_icon">-</span>
                                                </button>
                                             </h2>
                                          </div>
                                          <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="inner_body">
                                                   <div class="row">
                                                      <div class="col-xs-12 col-sm-12 gb">
                                                       
                                                        <!-- @foreach($docData4 as $ECData)
                                                         <div class="custom_checkbox ">
                                                            
                                                            <label for="checkbox_1"><span class="m-r-10 font-600">{{$ECData->condition_no}} .</span>{{$ECData->document}}</label>

                                                         </div>
                                                           @endforeach -->
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <!--<div class="view_btn">-->
                                    <!--   <input type="button" name="view" value="View" class="view_document">-->
                                    <!--</div>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                        @if((session('role')=='admin') || (session('role')=='project_Manager'))



                        @else
                   
                     </div>

  
  <div class="col-xs-12 col-sm-12 col-md-4">
    <form method="post" id="csv_upload_from" action="{{URL::to('import_csv_data')}}" enctype='multipart/form-data'>
                           <div class="document_upload_wrapper">
                              <div class="document_attach_wrapper">
                                 <h3>Upload Documents</h3>
                                 <div class="select_state_cat_document">
                                    <div class="row">
                                       <div class="col-xs-12 col-sm-4">
                                          <div class="form-group">
                                             <label for="selectcatefory">State</label>
                                          </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-8">
                                          <div class="form-group">
                                             <select class="form-control" id="selectstate" name="selectstate">
                                               @foreach($statelist as $state)
                                               <option value="{{$state->stateid}}">{{$state->name}}</option>
                                               @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-4">
                                          <div class="form-group">
                                             <label for="selectcatefory">Sector</label>
                                          </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-8">
                                          <div class="form-group">
                                             <select class="form-control" id="selectsector" name="selectsector">
                                                @foreach($sectorlist as $sector)
                                                <option value="{{$sector->id}}">{{$sector->sector_name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-4">
                                          <?php $Categorylist = DB::table('grc_stages')->select('*')->get();?>
                                          <div class="form-group">
                                             <label for="selectcatefory">Category</label>
                                          </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-8">
                                          <div class="form-group">
                                              <select class="form-control" id="selectcategory" name="selectcategory">
                                                @foreach($Categorylist as $stage)
                                                <option value="{{$stage->stage_name}}">{{$stage->stage_name}}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              {{ csrf_field() }}
                              <div class="task_upload_wrapper">
                                 <div class="uploading_task">
                                    <img src="assets/images/uploa_icon.png" alt="" title="">
                                    <input type="file" name="task_upload">
                                 </div>
                                 <div class="inline_form">
                                    <div class="sample_form">
                                       <input type="text" name="browsefiles" class="browse_file" id="browsefiles" placeholder="Browse Files">
                                       <em>Accept only csv files</em>
                                       <a href="{{URL::to('/Sample_doc.csv')}}" download>Download format</a>
                                    </div>
                                    <div class="sampe_submit">
                                       <!--<input type="text" name="browsefiles" class="browse_file" id="browsefiles" placeholder="Browse Files">-->
                                    <input type="submit" name="upload" class="submit_btn" value="Upload">
                                    </div>
                                 </div>
                                 <!-- <input type="" name=""> -->
                              </div>
                           </div>
                           </form>
                        </div>

                      @endif
                  </div>
               </div>
               <!-- container-fluid -->
            </div>
            <!-- content -->
            <!-- <footer class="footer">© 2019 GRC </footer> -->
         </div>
         @stop
        @section('extra_js')

<script>


    $(document).ready(function() {
  $("#csv_upload_from").validate({
    rules: {
      task_upload : {
        required: true,
        
      },
     
       
      
    },
  
  });
});
   

   


</script>

@stop