<!DOCTYPE html>

<html class="html" lang="en-US">

    <head>

        <meta charset="UTF-8">

	    <link rel="profile" href="http://gmpg.org/xfn/11">

	    <title>Compliance Report</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
        .page-break {
         page-break-after: always;
        }
        </style>

    </head>

    <body>

     @if($type_report == 'sixmonthreport')

     

    @php($class = 'HALF YEARLY COMPLIANCE REPORT')

     

     

     @else

     

      @php($class = 'Monthly YEARLY COMPLIANCE REPORT')

     

     

     @endif

        <div style="width:800px;margin:0 auto;background:#fff;padding:20px;">

            <div style="padding:20px">

                <h1 style="text-align:center;color:darkblue">{{$class}}</h1>

                <h3 style="text-align:center;color:black;margin:40px 0">FOR</h3>

                <h1 style="text-align:center;color:#b21b1b"> {{strtoupper($report[0]->project_type)}} PROJECT "{{strtoupper($report[0]->project_name)}}"</h1>

                <h3 style="text-align:center;color:black;margin:40px 0">At</h3>

                <h2 style="text-align:center;color:blue">{{strtoupper($report[0]->project_alias)}}, {{strtoupper($report[0]->city_name)}}  {{strtoupper($report[0]->state_name)}}

                    </h2>

                    <h3 style="text-align:center;color:black;margin:40px 0">By</h3>

                    <h2 style="text-align:center;color:#ff5200">{{strtoupper($report[0]->org_name)}}

                        </h2>  

                        <p style="font-size:21px;font-weight:600;text-align: justify;margin-top:20px;">

                            POINT-WISE COMPLIANCE OF STIPULATED ENVIRONMENTAL CONDITIONS/ SAFEGUARDS IN THE ENVIRONMENTAL CLEARANCE

EC Letter No. {{strtoupper($report[0]->letter_no)}}  FOR  {{strtoupper($report[0]->project_type)}} PROJECT‘{{strtoupper($report[0]->project_name)}}’{{strtoupper($report[0]->project_alias)}}, {{strtoupper($report[0]->city_name)}} {{strtoupper($report[0]->state_name)}} BY {{strtoupper($report[0]->org_name)}}.



                        </p>  

                        <table border="1" style="border-collapse: collapse; width:100%; margin-top:115px">

                            <tbody>

                                <tr>

                                    <th style="text-align: left;padding: 5px;vertical-align: top;width: 10%;">SL.No</th>

                                    <th style="text-align: left;padding: 5px;vertical-align: top;width: 45%;">Conditions</th>

                                    <th style="text-align: left;padding: 5px;vertical-align: top;width: 45%;">Status of Compliance </th>

                                </tr>

                                <tr>

                                    <th  style="text-align: left;padding: 5px;vertical-align: top;" colspan="3">PART A – GENERAL  CONDITIONS: </th>

                                </tr>

                                

                                <?php

                                $html = '';

                                $i = 1;

                                       
                                        if(isset($report)){
                                         foreach ($report as  $project) {

                                      
                                             if(isset($project->Generic_task)){
                                           foreach ($project->Generic_task as  $taskall) {

                                    



      

                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskall->id)->orderBy('grc_task_remarks.id', 'desc')->first();



                                           



                                            if(isset($remark->task_remark) && !empty($remark->task_remark)){

                                                  $task_remark  = $remark->task_remark;

                                            }else{



                                              $task_remark = 'New';



                                            }

                                            if(isset($remark->task_status) && !empty($remark->task_status)){

                                                  $task_status  = $remark->task_status;

                                            }else{



                                              $task_status = 'New';



                                            }

                                            

                                              $keyword = 1; 

                                             if(isset($taskall->Generic_tast_document) && !empty($taskall->Generic_tast_document)){

                                               

                                              foreach ($taskall->Generic_tast_document as $ke => $document) {

                                               if(isset($document->document) && !empty($document->document)){

                                                  $document  = $document->document;

                                                           

                                                 foreach(explode('|',$document) as $doc){        



                                                  $info = pathinfo(public_path('/uploads_remarkdoc/').$doc);

                                                    $ext = $info['extension'];

                                                   

                                                   if($ext == 'gif' || $ext == 'png' || $ext == 'bmp'|| $ext == 'jpeg'|| $ext == 'jpg' || $ext == 'PNG' || $ext == 'GIF' || $ext == 'JPG'){



                                                     



                                                     $html .=' <div style="page-break-before: always;"><img width="500px" src="'.public_path('/uploads_remarkdoc/'.$doc) .'"><p style="float:right;">Annexure '.$i.'.'.$keyword++.'</p><div>';



                                                   }else{



                                                     $html .='&nbsp;';



                                                   }

                                               }

                                                 



                                            }else{



                                              $document = '&nbsp;';



                                            }

                                          

                                              }

                                               

                                             }



                                                 

                                            

                                            ?>

                                <tr>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;">{{$i}}.</td>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;">{{$taskall->task_name}}</td>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;">{{$task_remark }}  

                                    <?php

                                    

                                    

                                     if(isset($taskall->Generic_tast_document) && !empty($taskall->Generic_tast_document)){

                                                    $keyword = 1;

                                              foreach ($taskall->Generic_tast_document as $key => $document) {

                                               if(isset($document->document) && !empty($document->document)){

                                                $document  = $document->document;

                                                     

                                                 foreach(explode('|',$document) as $doc){  

                                                     

                                                     ?>

                                                     

                                                     

                                             <b ><br>  Annexure {{$i}} .{{$keyword++}} </b>

                                                

                                                <?php

                                                

                                                 } 



                                                }



                                              }

                                             $i++;

                                            }

                                        

                                     ?>

                                    

                                    

                                    

                                    </b>

                                        </td>

                                </tr>

                                <?php } } } }?>

                                

                                

                               

                                

                          

                            </tbody>

                        </table>

                        <table border="1" style="border-collapse: collapse; width:100%">

                            <tbody>

                                <tr>

                                    <th  style="text-align: left;padding: 5px;vertical-align: top;" colspan="3">PART B – SPECIFIC CONDITIONS: </th>

                                </tr>

                               <?php

                                $html1 = '';

                                $i = 1;



                                         foreach ($report as  $project) {

                                      

                                           foreach ($project->Specific_task as  $taskall) {

                                    



      

                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskall->id)->orderBy('grc_task_remarks.id', 'desc')->first();



                                           



                                            if(isset($remark->task_remark) && !empty($remark->task_remark)){

                                                  $task_remark  = $remark->task_remark;

                                            }else{



                                              $task_remark = 'New';



                                            }

                                            if(isset($remark->task_status) && !empty($remark->task_status)){

                                                  $task_status  = $remark->task_status;

                                            }else{



                                              $task_status = 'New';



                                            }

                                            

                                              $keyword = 1; 

                                             if(isset($taskall->Specific_tast_document) && !empty($taskall->Specific_tast_document)){

                                               

                                              foreach ($taskall->Specific_tast_document as $ke => $document) {

                                               if(isset($document->document) && !empty($document->document)){

                                                  $document  = $document->document;

                                                           

                                                 foreach(explode('|',$document) as $doc){        



                                                  $info = pathinfo(public_path('/uploads_remarkdoc/').$doc);

                                                    $ext = $info['extension'];

                                                   

                                                   if($ext == 'gif' || $ext == 'png' || $ext == 'bmp'|| $ext == 'jpeg'|| $ext == 'jpg' || $ext == 'PNG' || $ext == 'GIF' || $ext == 'JPG'){



                                                     



                                                     $html1 .=' <div style="page-break-before: always;"><img width="500px" src="'.public_path('/uploads_remarkdoc/'.$doc) .'"><p style="float:right;">Annexure '.$i.'.'.$keyword++.'</p></div>';



                                                   }else{



                                                     $html1 .='&nbsp;';



                                                   }

                                               }

                                                 



                                            }else{



                                              $document = '&nbsp;';



                                            }

                                          

                                              }

                                               

                                             }



                                                 

                                            

                                            ?>

                                <tr>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;width:10%">{{$i}}.</td>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;width:45%">{{$taskall->task_name}}</td>

                                    <td style="text-align: left;padding: 5px;vertical-align: top;width:45%">{{$task_remark}}  

                                    <?php

                                    

                                    

                                     if(isset($taskall->Specific_tast_document) && !empty($taskall->Specific_tast_document)){

                                                    $keyword = 1;

                                              foreach ($taskall->Specific_tast_document as $key => $document) {

                                               if(isset($document->document) && !empty($document->document)){

                                                $document  = $document->document;

                                                     

                                                 foreach(explode('|',$document) as $doc){  

                                                     

                                                     ?>

                                                     

                                                     

                                             <b> <br> Annexure {{$i}} .{{$keyword++}}  <b> 

                                                

                                                <?php

                                                

                                                 } 



                                                }

                                               

                                              }

                                              $i++;



                                            }

                                           

                                    

                                   

                                    

                                     ?>

                                    

                                    

                                    

                                    </b>

                                        </td>

                                </tr>

                                <?php } } ?>

                            </tbody>

                        </table>

                        

                        {!!$html!!}

                        

                          {!!$html1!!}

                </div>

        </div>

    </body>

</html>