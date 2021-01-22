<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use DB;
use Redirect;
use Response;


class CronController extends Controller
{
   public function send_monthly_report(){

   	 $curentdatae= date('Y-m');

      //dd($curentdatae);

   //  $sixmonthpreviews = date('Y-m',strtotime('-6 months'));

      $projecReport = DB::table('grc_project');

       $projecReport->where(DB::raw("(DATE_FORMAT(grc_project.start_date,'%Y-%m'))"), ">=", $curentdatae);

    
     $projectReportlist =  $projecReport->get();

   foreach ($projectReportlist as $key => $projectReportlists) {

    $projectReportlists->condiction = DB::table('grc_project_condition_doc')->where('project_id',$projectReportlists->id)->get();

     $projectReportlists->task = DB::table('grc_task')->where('project_id',$projectReportlists->id)->get();

     foreach ($projectReportlists->task as $key => $taskdetails) {

      $taskdetails->tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();
      
     }

   }

//dd($projectReportlist);
    
   
     $output = '<table width="100%" style="border-collapse: collapse; border: 0px;"
                                        >
                                        <thead>
                                            <tr>
                                  <th style="border: 1px solid; padding:12px;" width="20%">S. No.</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Task ID</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Condition</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Status of Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">probability</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Attachments</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
     $html = '';
      $i = 1;
      if(isset($projectReportlist) && !empty($projectReportlist)){
     foreach ($projectReportlist as  $project) {
  
       foreach ($project->task as  $taskall) {


      
                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskall->id)->orderBy('grc_task_remarks.id', 'desc')->first();

                                           

                                            if(isset($remark->task_remark) && !empty($remark->task_remark)){
                                                  $task_remark  = $remark->task_remark;
                                            }else{

                                              $task_remark = '&nbsp;';

                                            }
                                            if(isset($remark->task_status) && !empty($remark->task_status)){
                                                  $task_status  = $remark->task_status;
                                            }else{

                                              $task_status = '&nbsp;';

                                            }

                                            if(isset($remark->Probability) && !empty($remark->Probability)){
                                                  $Probability  = $remark->Probability;
                                            }else{

                                              $Probability = '&nbsp;';

                                            }
                                            
                                              
                                
                                            
                                           

         $output .= ' <tr>
                                         <td style="border: 1px solid; padding:12px;" width="20%">'.$i.'</td>
                                        <td style="border: 1px solid; padding:12px;" width="20%">'.$taskall->task_id.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'.$taskall->task_name.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%"> '.$task_remark.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'. $task_status.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'.$Probability.'</td>';
                                                  $output .= '<td style="border: 1px solid; padding:12px;" width="20%"> <ul>';
                                                      
                                                   if(isset($taskall->tast_document) && !empty($taskall->tast_document)){
                                                    $keyword = 1;
                                              foreach ($taskall->tast_document as $key => $document) {
                                               if(isset($document->document) && !empty($document->document)){
                                                $document  = $document->document;
                                                 $output .= '<li> Annexure '.$i.'.'.$keyword++.'</li>';
                                                  

                                                }

                                              

                                               
                                              }

                                            }
                                               
                                             
                                              $output .= '</ul></td></tr>';

                                              $i++;
                                             
                                             
       }
     }
   }else{

     $output .= '<tr><td colspan="7">No Recoud Found</td></tr>';

   }

    
     $output .= ' </tbody></table>';


   
       $to = 'usrivastava@kloudrac.com';
                                 $sub = "Task Cannot Be Completed";
                                 $from = "dsaini@kloudrac.com";
                                 $fromname = "Diksha";
                                 $response = sendMail($to,$sub,$from,$fromname,$output);

                                 dd($response);
    
    }

}

  // }


    public function sendSixMonthlyReportReport(){

   

        $curentdatae= date('Y-m');

       $sixmonthpreviews = date('Y-m',strtotime('-6 months'));



   $projecReport = DB::table('grc_project');

    $projecReport->whereBetween(DB::raw("(DATE_FORMAT(grc_project.start_date,'%Y-%m'))"), [$sixmonthpreviews, $curentdatae]);

    
     $projectReportlist =  $projecReport->get();

   foreach ($projectReportlist as $key => $projectReportlists) {

    $projectReportlists->condiction = DB::table('grc_project_condition_doc')->where('project_id',$projectReportlists->id)->get();

     $projectReportlists->task = DB::table('grc_task')->where('project_id',$projectReportlists->id)->get();

     foreach ($projectReportlists->task as $key => $taskdetails) {

      $taskdetails->tast_document = DB::table('grc_project_task_document')->where('task_id',$taskdetails->id)->get();
      
     }

   }

//dd($projectReportlist);
    
   
     $output = '<table width="100%" style="border-collapse: collapse; border: 0px;"
                                        >
                                        <thead>
                                            <tr>
                                  <th style="border: 1px solid; padding:12px;" width="20%">S. No.</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Task ID</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Condition</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Status of Compliance</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">probability</th>
                                                <th style="border: 1px solid; padding:12px;" width="20%">Attachments</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
     $html = '';
      $i = 1;
      if(isset($projectReportlist) && !empty($projectReportlist)){
     foreach ($projectReportlist as  $project) {
  
       foreach ($project->task as  $taskall) {


      
                                          $remark = DB::table('grc_task_remarks')->where('task_id',$taskall->id)->orderBy('grc_task_remarks.id', 'desc')->first();

                                           

                                            if(isset($remark->task_remark) && !empty($remark->task_remark)){
                                                  $task_remark  = $remark->task_remark;
                                            }else{

                                              $task_remark = '&nbsp;';

                                            }
                                            if(isset($remark->task_status) && !empty($remark->task_status)){
                                                  $task_status  = $remark->task_status;
                                            }else{

                                              $task_status = '&nbsp;';

                                            }

                                            if(isset($remark->Probability) && !empty($remark->Probability)){
                                                  $Probability  = $remark->Probability;
                                            }else{

                                              $Probability = '&nbsp;';

                                            }
                                            
                                              
                                
                                            
                                           

         $output .= ' <tr>
                                         <td style="border: 1px solid; padding:12px;" width="20%">'.$i.'</td>
                                        <td style="border: 1px solid; padding:12px;" width="20%">'.$taskall->task_id.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'.$taskall->task_name.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%"> '.$task_remark.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'. $task_status.'</td>
                                                <td style="border: 1px solid; padding:12px;" width="20%">'.$Probability.'</td>';
                                                  $output .= '<td style="border: 1px solid; padding:12px;" width="20%"> <ul>';
                                                      
                                                   if(isset($taskall->tast_document) && !empty($taskall->tast_document)){
                                                    $keyword = 1;
                                              foreach ($taskall->tast_document as $key => $document) {
                                               if(isset($document->document) && !empty($document->document)){
                                                $document  = $document->document;
                                                 $output .= '<li> Annexure '.$i.'.'.$keyword++.'</li>';
                                                  

                                                }

                                              

                                               
                                              }

                                            }
                                               
                                             
                                              $output .= '</ul></td></tr>';

                                              $i++;
                                             
                                             
       }
     }
   }else{

     $output .= '<tr><td colspan="7">No Recoud Found</td></tr>';

   }

    
     $output .= ' </tbody></table>';


   
       $to = 'usrivastava@kloudrac.com';
                                 $sub = "Task Cannot Be Completed";
                                 $from = "dsaini@kloudrac.com";
                                 $fromname = "Diksha";
                                 $response = sendMail($to,$sub,$from,$fromname,$output);

                                 dd($response);
    
    }

}
