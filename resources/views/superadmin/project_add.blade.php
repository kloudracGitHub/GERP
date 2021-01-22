@extends('superadmin_layout')
   @section('content')
   <style>
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 10%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
</style>


<div class="content-page">
            <!-- Start content -->
            <div class="content p-0">
                <div class="container-fluid">
                 
                    <div class="page-title-box">
                        <div class="row align-items-center bredcrum-style">
                            <div class="col-sm-6">
                                <h4 class="page-title">Add Projects</h4>
                            </div>
                            <div class="col-sm-6">
                               
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="add_project_wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <form class="court-info-form" id="add_project"  role="form" method="POST" action="{{URL::to('/Project-add')}}"  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">

                                            @if(session('role') == 'admin' || session('role') == 'project_Manager')
                                            @php(
                                            
                                            $org = DB::table('grc_organization')->where('id',session('org_id'))->get()
                                            
                                            )
                                               <div class="form-group">
                                                <label for="organizationname">Organization Name</label><span style="color:red;">*</span>
                                                <select name="organizationname" id="organizationname" class="form-control project_box" readonly>
                                                  <option value="">Select Option</option>
                                                    @foreach($org as $orgData)
                                                    <option value="{{$orgData->id}}" @if(session('org_id') == $orgData->id) selected @endif>{{$orgData->org_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div id="organizationname_error"></div>
                                                   @error('organizationname')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                               
                                            </div>
                                             @else
                                            
                                                <div class="form-group">
                                                <label for="organizationname">Organization Name</label><span style="color:red;">*</span>
                                                <select name="organizationname" id="organizationname" class="form-control project_box">
                                                  <option value="">Select Option</option>
                                                    @foreach($orgname as $orgData)
                                                    <option value="{{$orgData->id}}">{{$orgData->org_name}}</option>
                                                    @endforeach
                                                </select>
                                                 <div id="organizationname_error"></div>
                                                   @error('organizationname')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                               
                                            </div> 
                                           @endif
                                          <!--   <div class="form-group">
                                                <label for="organizationname">Organization Name</label>
                                                <select name="organizationname" id="organizationname" class="form-control project_box">
                                                    @foreach($orgname as $orgData)
                                                    <option value="{{$orgData->id}}">{{$orgData->org_name}}</option>
                                                    @endforeach
                                                </select>
                                               
                                            </div> -->
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectname">Project Name</label><span style="color:red;">*</span>
                                                <input type="text" name="projectname" id="projectname" value="{{ old('projectname') }}" maxlenght="60" class="form-control project_box">
                                                  <div id="projectname_error"></div>
                                                  @error('projectname')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                             <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectname">EC Letter No</label><span style="color:red;">*</span>
                                                <input type="text" name="letter_no" id="letter_no" value="{{ old('letter_no') }}" maxlenght="60" class="form-control project_box">
                                                  <div id="projectname_error"></div>
                                                  @error('letter_no')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                         <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectalias">Project Location</label><span style="color:red;">*</span>
                                                <input type="text" name="projectalias" value="{{ old('projectalias') }}" id="projectalias" maxlenght="60" class="form-control project_box">
                                                
                                                 <div id="projectalias_error"></div>
                                                 @error('projectalias')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                     
                                   <?php  $pmname = DB::table('grc_user')->where('status',1);
                                   if(session('role') !='superadmin'){
                                       
                                    // $pmname->where('org_id',session('org_id'));
                                    
                                    $pmname->where('org_id',session('org_id'));
                                     
                                   }
                                    //$pmname->where('created_by',session('userId'));
                                  
                                    $manager= $pmname->where('role','project_Manager')->get();

                                   ?>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectalias">Project Manager</label><span style="color:red;">*</span>
                                                
                                                 <select name="projectmanager" id="projectmanager"  class="form-control project_box">
                                                  <option value="">Select Option</option>
                                                     @foreach($manager as $pm)
                                                     <option value="{{$pm->id}}">{{$pm->first_name}}  {{$pm->last_name}}</option>
                                                     @endforeach
                                                 </select>
                                                  <div id="projectmanager_error"></div>
                                                   @error('projectmanager')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                                 
                                                
                                            </div>
                                        </div>

                                        <!--<div class="col-xs-12 col-sm-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label for="projectalias">Password</label><span style="color:red;">*</span>-->
                                                
                                        <!--         <input type="password" name="propassword" class="form-control project_box">-->
                                        <!--           @error('propassword')-->
                                        <!--        <div style="color:red;">{{ $message }}</div>-->
                                        <!--        @enderror-->
                                                
                                                
                                        <!--    </div>-->
                                        <!--</div>-->

                                       

                                        <div class="col-xs-12 col-sm-6">
                                            <?php  $typelist = DB::table('grc_type')->get();?>
                                            <div class="form-group">
                                                <label for="projecttype">Project Type</label><span style="color:red;">*</span>
                                                <select name="projecttype" id="projecttype" class="form-control project_box">
                                                    <option value="">Select Option</option>
                                                    @foreach($typelist as $value)
                                                    <option value="{{$value->type_name}}">{{$value->type_name}}</option>
                                                    @endforeach
                                                </select>
                                                 <div id="projecttype_error"></div>

                                                  @error('projecttype')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <?php  $stagelist = DB::table('grc_stages')->get();?>
                                            <div class="form-group">
                                                <label for="projectstage">Type Of NOC</label><span style="color:red;">*</span>
                                                <select name="projectstage" id="projectstage" class="form-control project_box">
                                                    <option value="">Select Option</option>
                                                      @foreach($stagelist as $value)
                                                    <option value="{{$value->stage_name}}">{{$value->stage_name}}</option>
                                                    @endforeach
                                                </select>
                                                 <div id="projectstage_error"></div>
                                                 @error('projectstage')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="pincode">Pin Code</label><span style="color:red;">*</span>
                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="pincode" id="pincode" value="{{ old('pincode') }}"  maxlength="6" class="form-control project_box">
                                                  
                                                   <div id="pincode_error"></div>
                                                  @error('pincode')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="landmark">Landmark</label><span style="color:red;">*</span>
                                                <input type="text" name="landmark" id="landmark" value="{{ old('landmark') }}" maxlenght="60" class="form-control project_box">
                                                  <div id="landmark_error"></div>
                                                  @error('landmark')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <?php  $typelist = DB::table('grc_sector')->get();?>
                                            <div class="form-group">
                                                <label for="sector">Sector</label><span style="color:red;">*</span>
                                                <select name="sector" id="sector" class="form-control project_box">
                                                    
                                                    <option value="">Select Option</option>
                                                    @foreach($typelist as $value)
                                                    <option value="{{$value->id}}">{{$value->sector_name}}</option>
                                                    @endforeach
                                                
                                                </select>
                                                  <div id="sector_error"></div>
                                                 @error('sector')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
      <div class="col-xs-12 col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="projecttype">Project Category</label>
                                                <select name="project_category" id="project_category" class="form-control project_box">
                                                    <option value="">Select Option</option>
                                                   
                                                    <option value="A">A</option>
                                                     <option value="B">B</option>
                                                      <option value="B1">B1</option>
                                                       <option value="B2">B2</option>
                                                    
                                                </select>
                                                 

                                                 
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectstate">State</label><span style="color:red;">*</span>
                                                <select name="projectstate" id="projectstate" class="form-control project_box">
                                                  <option value="">Select Option</option>
                                                    @foreach($CData as $result)
                                                    <option value="{{$result['stateid']}}">{{$result['statename']}}</option>
                                                    @endforeach
                                                </select>
                                                <div id="projectstate_error"></div>
                                                 @error('projectstate')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                         
                                         

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectcity">City</label><span style="color:red;">*</span>
                                                <select name="projectcity" id="projectcity" class="form-control project_box citylist">

                                             
                                                </select>
                                                 <div id="projectcity_error"></div>
                                                  @error('projectcity')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                         <?php 
                                         $currency = DB::table('main_currency')->where('isactive',1)->get();
                                         ?>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectcurrency">Currency</label><span style="color:red;">*</span>
                                                <select name="projectcurrency" id="projectcurrency" class="form-control project_box">
                                                    @foreach($currency as $value)
                                                    <option value="{{$value->id}}" @if($value->id == 4) selected @endif>{{$value->currencycode}}</option>
                                                   @endforeach
                                                </select>
                                                   <div id="projectcurrency_error"></div>
                                                  @error('projectcurrency')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <?php  $statuslist = DB::table('grc_status')->get();?>
                                                <label for="prstatus">Project Status</label><span style="color:red;">*</span>
                                                <select name="prstatus" id="prstatus" class="form-control project_box">
                                                   <option value="">Select Option</option>
                                                    @foreach($statuslist as $value)
                                                    <option value="{{$value->status_name}}">{{$value->status_name}}</option>
                                                    @endforeach
                                                </select>
                                                  <div id="prstatus_error"></div>
                                                  @error('prstatus')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="estimatedhrs">Project Estimated Hours</label><span style="color:red;">*</span>
                                                <input type="text" onkeypress="preventNonNumericalInput(event)" name="estimatedhrs" id="estimatedhrs"  maxlength="4"  value="{{ old('estimatedhrs') }}" class="form-control project_box">
                                                 <div id="estimatedhrs_error"></div>
                                                 @error('estimatedhrs')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                                
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectstart">Start Date</label><span style="color:red;">*</span>
                                                <input type="date" placeholder="dd/mm/yyyy" name="projectstart" id="projectstart" value="{{ old('projectstart') }}" class="dateTxt form-control project_box">
                                                  <div id="projectstart_error"></div>
                                                 @error('projectstart')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="projectend">End Date</label><span style="color:red;">*</span>
                                                <input type="date" placeholder="dd/mm/yyyy" name="projectend" id="projectend" value="{{ old('projectend') }}" class="dateTxt form-control project_box">
                                                <div id="projectend_error"></div>
                                                 @error('projectend')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="prDescription">Project Description</label><span style="color:red;">*</span>
                                                <textarea rows="4" name="prDescription" id="prDescription" class="form-control project_box">{{ old('prDescription') }}</textarea>
                                                  <div id="prDescription_error"></div>
                                                  @error('prDescription')
                                                <div style="color:red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        

                                        <div class="col-xs-12 col-sm-12 text-center">
                                                <button type="button" id="project_preview" class="previvew_btn" onclick="getprojectValue();">Preview</button>
                                                <!--<input type="submit" name="submit"  value="Submit"  onclick="submitDetailsForm()" class="submit_btn">-->
                                                <button type="submit"  class="submit_btn ">Submit</button>
                                       
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6">
                                            <div class="see_details">
                                                <p>Click <a href="project_details.html">here</a> to see project details.</p>
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
<!------------------------------------------>
<!-------------- Preview Modal ------------->
<!------------------------------------------>
<div class="modal fade bd-example-modal-xl" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0 header_color" id="myModalLabel">Project Preview</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--    <span aria-hidden="true">&times;</span>-->
                <!--</button>-->
            </div>
            <div class="modal-body">
                <div class="preview_mode">
                    <div class="row b-b">
                         <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                          <label for="empcode" class="col-lg-4 col-form-label">Organization Name</label>
                                          <div class="col-lg-8 col-form-label">
                                             <label id="previewproorg" class="myprofile_label m-0">N/A</label>
                                          </div>
                                       </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label for="empcode" class="col-lg-4 col-form-label">Project Name</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewproname">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label for="empcode" class="col-lg-4 col-form-label">Project Location</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewproalias">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label for="empcode" class="col-lg-4 col-form-label">Project Stage</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprostage">Housing Property</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label for="empcode" class="col-lg-4 col-form-label">Project Type</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprotype">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Pin Code</label>
                                <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewpropincode">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                       
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Sector</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprosector">N/A</label>
                                </div>
                            </div>
                        </div>
                          <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Project Category</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprocategory">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                              <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Landmark</label>
                                   <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprolandmark">N/A</label>
                                </label>
                            </div>
                        </div>
                         </div>
                           <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Type of NOC</label>
                                   <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewnoc">N/A</label>
                                </label>
                            </div>
                        </div>
                         </div>
                         </div>
                           <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">State</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprostate">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">City</label>
                                <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprocity">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Currency</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprocurrency">N/A</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Project Status</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprostatus">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                       
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Start Date</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprostart">N/A</label>
                                </div>
                            </div>
                        </div>
                           <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">End Date</label>
                                  <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewproend">N/A</label>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="row b-b">
                              <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Estimate hours</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewproestimate">N/A</label>
                                </div>
                            </div>
                        </div>
                          <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Project Description</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewprodes">N/A</label>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="row b-b">
                              <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <label class="col-lg-4 col-form-label">Letter No</label>
                                 <div class="col-lg-8 col-form-label">
                                <label class="myprofile_label m-0" id="previewletter_no">N/A</label>
                                </div>
                            </div>
                        </div>
                  
                     </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------>
<!-------------- Preview Modal ------------->
<!------------------------------------------>
@stop

@section('extra_js')

 <script language="javascript" type="text/javascript">
 
  $( "#organizationname" ).change(function() {
   
     var cid =  $("#organizationname").val();
   
     // alert(cid);
   
     var html = '';
   
         $.ajax({
   
             url:siteurl+'/public/mng_list/'+cid,
   
             type: "GET",
   
             cache: false,
   
             dataType: 'json',
   
             success: function (response) {
                 console.log(response);
                    html +=' <option class="p-option" value="">Select Option</option> ';
                 if (response.length > 0) {
                     $.each(response, function (k, v)
                     {
                         html +=' <option class="p-option" value="'+v.id+'">'+v.name+'</option> ';
   
                     });
                 }else{ 
                     html += 'state not available';
                 }
                  $("#projectmanager").html(html);
             }
        })
   });
   
    
    
    
    function getprojectValue(){
            // Selecting the input element and get its value 
            
            
            

            
            
            
            
            var projectname = document.getElementById("projectname").value;
            var projectalias = document.getElementById("projectalias").value;
            var project_category=$("#project_category option:selected").text();
            var landmark = document.getElementById("landmark").value;
            var estimatedhrs = document.getElementById("estimatedhrs").value;
            var projectstart = document.getElementById("projectstart").value;
            var organizationname = $("#organizationname option:selected").text();
            var projecttype = $("#projecttype option:selected").text();
            var projectstage = $("#projectstage option:selected").text();
            var sector = $("#sector option:selected").text();
            var projectstate = $("#projectstate option:selected").text();
            var projectcity = $("#projectcity option:selected").text();
            var prstatus = $("#prstatus option:selected").text();
            var projectcurrency = $("#projectcurrency option:selected").text();
            var pincode = document.getElementById("pincode").value;
            var projectend = document.getElementById("projectend").value;
            var prDescription = document.getElementById("prDescription").value;
            var letter_no = document.getElementById("letter_no").value;


           var projectstart = $('#projectstart').val();
                    var projectstart = new Date(projectstart);
                 var dd = String(projectstart.getDate()).padStart(2, '0');
                 var mm = String(projectstart.getMonth() + 1).padStart(2, '0'); //January is 0!
                 var yyyy = projectstart.getFullYear();

                 projectstart = dd + '-' + mm + '-' + yyyy;
          var projectend = $('#projectend').val();
                    var projectend = new Date(projectend);
                 var dd = String(projectend.getDate()).padStart(2, '0');
                 var mm = String(projectend.getMonth() + 1).padStart(2, '0'); //January is 0!
                 var yyyy = projectend.getFullYear();

                 projectend = dd + '-' + mm + '-' + yyyy;
           
            $("#previewproname").html(projectname);
            $("#previewproalias").html(projectalias);
            $("#previewprocategory").html(project_category);
              $("#previewnoc").html(projectstage);
            $("#previewpropincode").html(pincode);
            $("#previewprolandmark").html(landmark);
            $("#previewproestimate").html(estimatedhrs);
            $("#previewprostart").html(projectstart);
            $("#previewproend").html(projectend);
            $("#previewprodes").html(prDescription);
            $("#previewproorg").html(organizationname);
            $("#previewprotype").html(projecttype);
            $("#previewprostage").html(projectstage);
            $("#previewprostatus").html(prstatus);
            $("#previewprocity").html(projectcity);
            $("#previewprosector").html(sector);
            $("#previewprostate").html(projectstate);
            $("#previewprocurrency").html(projectcurrency);
            $("#previewletter_no").html(letter_no);
            
            
            
        }
    
    
    
  $(document).ready(function() {
  $("#add_project").validate({
    rules: {
      organizationname : {
        required: true,
       
      },
       projectname : {
        required: true,
        minlength: 3,
        maxlength: 60,
      },
       projectalias : {
        required: true,
        
      },
       letter_no : {
        required: true,
        
      },
      
       projectmanager : {
        required: true,
        
      },
       projecttype : {
        required: true,
        
      },
    //   project_category: {
    //     required: true,
        
    //   },
       projectstage : {
        required: true,
        
      },
       landmark : {
        required: true,
        
      },
       sector : {
        required: true,
        
      },
        estimatedhrs : {
        required: true,
        number: true,
        
      },
        projectstart : {
        required: true,
        
      },
      projectend : {
        required: true,
        
      },
      prDescription : {
        required: true,
        
      },
      
      prstatus: {
        required: true,
        
      },
   
       projectstate : {
        required: true,
        
      },
       projectcity : {
        required: true,
        
      },
       pincode : {
        required: true,
        minlength: 6
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
      projectname: {
        minlength: "Project should be at least 3 characters",
        maxlength: "Project should be at Max 60 characters",
      },
     
      pincode: {
        minlength: "Pin Code should be at least 6 Digit"
      },
      age: {
        required: "Please enter your age",
        number: "Please enter your age as a numerical value",
        min: "You must be at least 18 years old"
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
    $('#project_preview').click(function()
    {
        $('#add_project').validate();
        if ($('#add_project').valid()) // check if form is valid
        {
            $('#exampleModalScrollable').modal('show');
        }
        else 
        {
            // just show validation errors, dont post
        }
    });

</script>

    


<script>

$(document).on('click','.submit_btn',function(){
    
    fromdate = $('#projectstart').val();
    todate = $('#projectend').val();
    
    
      var d1 = Date.parse(fromdate);
                  var d2 = Date.parse(todate);
                  if (d1 > d2) {
                      alert ("Please Select Valid Date");
                      var error = 0;
                      return false;
                  }
    
});
$(function(){$('.dateTxt').datepicker(); }); 
</script>

@stop