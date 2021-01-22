<?php


use Carbon\Carbon as Carbon;

use Illuminate\Support\Facades\Cache as Cache;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;




if (!function_exists('sendMailNotification')) {

function sendMailNotification($sub,$msg,$to,$from,$fromname)
   {
       try {
           $mail = Mail::send([], [], function ($message) use ($sub,$msg,$to,$from,$fromname) {

               $message->from($from, $fromname);
               $message->to($to);
               $message->subject($sub);
               $message->setBody($msg, 'text/html'); // for HTML rich messages
           });

           if ($mail) {
               return true;
           } else {
               return false;
           }
       } catch (Exception $e) {
           throw new HttpException(500, $e->getMessage());
       }
   }
}





if (!function_exists('MultiSendEmail')) {

 function MultiSendEmail($emaiArr = [],$subject,$from,$fromname,$content)
    {
try {
Mail::send([], [], function($message) use ($emaiArr,$subject, $from, $fromname, $content)
{    
                $message->from($from, $fromname);
                $message->to($emaiArr);
                $message->subject($subject);
                $message->setBody($content, 'text/html'); // for HTML rich messages   
});
if(Mail:: failures()){

    return false;

 }else{

    return true;

 }
  } catch (Exception $e) {
    return $e->getMessage();
        }
}
}


if (!function_exists('org_increment')) {

 function org_increment()
    {
$auto_increment = DB::table('grc_organization')->orderBy('id','DESC')->first();
 
 if(isset($auto_increment->org_unique_id)){

   return str_pad((int)$auto_increment->org_unique_id + 1, 3, '0', STR_PAD_LEFT);

 }else{

    return str_pad(1, 3, '0', STR_PAD_LEFT);

 }


    }
  }

  if (!function_exists('project_increment')) {

 function project_increment()
    {
$auto_increment = DB::table('grc_project')->orderBy('id','DESC')->first();
 
 if(isset($auto_increment->project_id)){

   return str_pad((int)$auto_increment->project_id + 1, 3, '0', STR_PAD_LEFT) + 1;

 }else{

    return str_pad(1, 3, '0', STR_PAD_LEFT);

 }


    }
  }

  if (!function_exists('task_increment')) {

 function task_increment()
    {
$auto_increment = DB::table('grc_task')->orderBy('id','DESC')->first();
 
 if(isset($auto_increment->task_id)){

   return str_pad((int)$auto_increment->task_id + 1, 3, '0', STR_PAD_LEFT);

 }else{

    return str_pad(1, 3, '0', STR_PAD_LEFT);

 }


    }
  }


   if (!function_exists('user_increment')) {

 function user_increment()
    {
$auto_increment = DB::table('grc_user')->orderBy('id','DESC')->first();
 
 if(isset($auto_increment->employee_id)){

   return str_pad($auto_increment->employee_id + 1, 3, '0', STR_PAD_LEFT);

 }else{

    return str_pad(1, 3, '0', STR_PAD_LEFT);

 }


    }
  }

