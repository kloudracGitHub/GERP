@extends('superadmin_layout')

   @section('content')

                <div class="content-page">

            <!-- Start content -->

            <div class="content p-0 report_wrapper">

                <div class="container-fluid">

                    <div class="page-title-box">

                        <div class="row align-items-center bredcrum-style m-b-20 p-10">

                            <div class="col-sm-6">

                                <h4 class="page-title">Project Report</h4>

                            </div>

                                <div class="col-sm-6 text-right">

                              <a class="btn btn-primary" href="<?php echo URL::to('export_csv')?>" 

                                    class="submit_btn" style="padding:9px;">Export CSV </a>

                            </div>

                              

                        </div>

                    </div>

                    <!-- end row -->

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <form method="get" id="report_form">

                                <div class="col-xs-12 col-sm-12 col-md-12">

                                    <div class="row">
                                            
                                            <?php

                                           $org = DB::table('grc_organization')->get();



                                            ?>


                                           <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="orgname">Organization</label>

                                                <select name="orgdropdown" id="orgdropdown"

                                                    class="form-control project_box" >

                                                    <option value="">Please Select</option>

                                                    @foreach($org as $orgs)



                                                     <option value="{{$orgs->id}}" @if(isset($_GET['orgdropdown'])) @if($orgs->id == $_GET['orgdropdown']) selected  @endif @endif>{{$orgs->org_name}}</option>



                                                     @endforeach

                                                </select>

                                            </div>

                                        </div>




                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="orgname">Project</label>

                                                <select name="projectdropdown" id="projectdropdown"

                                                    class="form-control project_box" >

                                                    <option value="">Please Select</option>

                                                    @foreach($project as $projects)



                                                     <option value="{{$projects->id}}" @if(isset($_GET['projectdropdown'])) @if($projects->id == $_GET['projectdropdown']) selected  @endif @endif>{{$projects->project_name}}</option>



                                                     @endforeach

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="typeofreport">Type of Report</label>

                                                <select name="typeofreport" id="typeofreport"

                                                    class="form-control project_box" >

                                                    <option value="">Please Select</option>

                                         <option value="monthlyreport"  @if(isset($_GET['typeofreport'])) @if('monthlyreport' == $_GET['typeofreport']) selected  @endif @endif   >Monthly Report</option>

                                         <option value="sixmonthreport" @if(isset($_GET['typeofreport'])) @if('sixmonthreport' == $_GET['typeofreport']) selected  @endif @endif>Six Monthly Report</option>

                                                </select>

                                            </div>

                                        </div>

                                         <?php  $stagelist = DB::table('grc_stages')->get();?>

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group">

                                                <label for="condition">Type of Condition</label>

                                                <select name="condition" id="condition"

                                                    class="form-control project_box" >

                                                    <option value="">Please Select</option>

                                                     @foreach($stagelist as $value)

                                                    <option value="{{$value->stage_name}}" @if(!empty($_GET['condition'])) @if($_GET['condition'] == $value->stage_name) selected @endif  @endif>{{ucwords($value->stage_name)}}</option>

                                                    @endforeach

                                                      <option value="all"   @if(!empty($_GET['condition'])) @if($_GET['condition'] == 'all') selected @endif  @endif>All</option>

                     <!--                                <option value="EC"  @if(isset($_GET['condition'])) @if('EC' == $_GET['condition']) selected  @endif @endif >EC</option>-->

                     <!--<option value="CTO"  @if(isset($_GET['condition'])) @if('CTO' == $_GET['condition']) selected  @endif @endif >CTO</option>';-->

                     <!--<option value="CTE"  @if(isset($_GET['condition'])) @if('CTE' == $_GET['condition']) selected  @endif @endif >CTE</option>';-->

                     <!-- <option value="GB"  @if(isset($_GET['condition'])) @if('GB' == $_GET['condition']) selected  @endif @endif >GB</option>';-->

                     <!--<option value="All"  @if(isset($_GET['condition'])) @if('All' == $_GET['condition']) selected  @endif @endif >All of the above</option>-->

                                                   

                                                </select>

                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-sm-6">

                                            <div class="form-group add_project_wrapper p-l-0">

                                                <input type="submit" name="submit" value="Search" class="submit_btn m-r-10">

                                             @if(isset($_GET['typeofreport']) && count($projectReportlist) > 0)



                                           <?php

                                            $projectid =   $_GET['projectdropdown'];

                                            $typeofreport =   $_GET['typeofreport'];

                                              $condition =   $_GET['condition'];





                                            ?>

                                                <a href="<?php echo URL::to('pdf')?>?projectdropdown=<?php echo $projectid;?>&typeofreport=<?php echo $typeofreport;?>&condition=<?php echo $condition; ?>" 

                                                    class="submit_btn m-r-10" style="padding:9px;">Export PDF </a>

                                          

                                                  

                                                    @endif

                                            </div>

                                        </div>

                                    </div>

                            </form>

                      

                        </div>



                        <div class="col-xs-12 col-sm-12">

                            <div class="">

                                <div class="card">

                                    <table id="datatable" class="table table-bordered nowrap"

                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                        <thead>

                                            <tr>

                                                <th class="text_ellipses" title="S. No." data-toggle="tooltip">S. No.</th>

                                                <th class="text_ellipses" title="Task ID" data-toggle="tooltip">Task ID</th>

                                                <th class="text_ellipses_max" title="Condition" data-toggle="tooltip">Condition</th>

                                                <th>Type</th>

                                                <th class="text_ellipses_max" title="Status of Compliance" data-toggle="tooltip">Status of Compliance</th>

                                                <th>Compliance</th>

                                                

                                                <th>Probability</th>

                                                <th>Attachments</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @php($i = 1)

                                           @foreach($projectReportlist as $projectdata)

                                            

                                           @if(isset($projectdata->task))

                                            @foreach($projectdata->task as $taskdata)

                                            <?php

                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskdata->id)->orderBy('grc_task_remarks.id', 'desc')->first();



                                            $document = DB::table('grc_project_task_document')->where('task_id',$taskdata->id)->orderBy('grc_project_task_document.id', 'desc')->first();



                                            ?>

                                            <tr>

                                                <td>{{$i++}}</td>

                                                <td>{{$taskdata->task_id}}</td>

                                                <td class="text_ellipses_max" data-toggle="tooltip" title="{{$taskdata->task_name}}">{{$taskdata->task_name}}</td>

                                                 <td>{{$taskdata->type}}</td>

                                                  <td>{{$remark->task_status??'NEW'}}</td>

                                                <td>{{$remark->task_remark??'No Remarks'}}</td>

                                              

                                                <td>{{$remark->Probability??'0%'}}</td>

                                                <td>



                                               

                                                       @if(isset($document->document) && !empty($document->document))

                                             @foreach(explode('|',$document->document) as $doc)

                                                         <a href="{{URL::to('uploads_remarkdoc/')}}/{{$doc}}" download=""> Attachment </a>

                                                         @endforeach

                                                      @endif

                                                   



                                                 

                                                

                                                </td>

                                            </tr>

                                            @endforeach

                                            @endif

                                            @endforeach



                                            @if(count($projectReportlist) == 0)

                                            <tr>

                                                <td colspan="8">Record Not Found</td>



                                            </tr>



                                            @endif



                                         

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- end row -->



                </div>

                <!-- container-fluid -->

            </div>

            <!-- content -->

            <!-- <footer class="footer">© 2019 GRC</footer> -->

        </div>

        <!-- ============================================================== -->

        <!-- End Right content here -->

        <!-- ============================================================== -->

    </div>

@stop





@section('extra_js')



 <script>


   $( "#orgdropdown" ).change(function() {

   

     var oid =  $("#orgdropdown").val();


     var html = '';


         $.ajax({

   

             url:siteurl+'/public/get_project/'+oid,

   

             type: "GET",

   

             cache: false,

   

             dataType: 'json',

   

             success: function (response) {

                 console.log(response);

                      

                       html = '';

                 if (response.length > 0) {

                     $.each(response, function (k, v)

                     {

                         html +=' <option class="p-option" value="'+v.id+'">'+v.project_name+'</option>';

   

                     });

                 
                   }else{

                     html +=' <option class="p-option" value="">Select Option</option>';

                 }

                  $("#projectdropdown").html(html);

             }

        })

   });















   // $( "#projectdropdown" ).change(function() {

   

   //   var pid =  $("#projectdropdown").val();

   

   //   // alert(cid);

   

   //   var html = '';

   

   //       $.ajax({

   

   //           url:siteurl+'/public/getcondition/'+pid,

   

   //           type: "GET",

   

   //           cache: false,

   

   //           dataType: 'json',

   

   //           success: function (response) {

   //               console.log(response);

                      

   //                     html = '';

   //                       @foreach($stagelist as $value)

   //                       html += '<option value="{{$value->stage_name}}">{{ucwords($value->stage_name)}}</option>';

   //                      @endforeach

                     

                      

   //               // if (response.length > 0) {

   //               //     $.each(response, function (k, v)

   //               //     {

   //               //         html +=' <option class="p-option" value="'+v.id+'">'+v.stage_name+'</option>';

   

   //               //     });

   //               // }else{

   //               //     html +=' <option class="p-option" value="">Select Option</option>';

   //               // }

   //                $("#condition").html(html);

   //           }

   //      })

   // });

   

</script>  


 <script type="text/javascript">



        $(document).ready(function() {
  $("#report_form").validate({
    rules: {
      orgdropdown : {
        required: true,
        
      },
       projectdropdown : {
        required: true,
        
        
      },
         typeofreport : {
        required: true,
        
        
      },
         condition : {
        required: true,
        
        
      },

   
    },

  });
});
    </script>



@stop