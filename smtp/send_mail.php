  <?php 
  include "classes/class.phpmailer.php"; // include the class file name
	  
function sendRegestrationMail($sub,$msg,$to)
{      
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'ryadav@kloudrac.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'kloudracrajesh'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("ryadav@kloudrac.com", "SMS"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}

// Function for forget password mail link.
function sendPasswordMail($sub,$msg,$to)
{ 

     
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'ryadav@kloudrac.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'kloudracrajesh'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("ryadav@kloudrac.com", "SMS"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}

// Function for when you changed your password, after that for inform only. 
function sendChangePasswordMail($sub,$msg,$to)
{ 

     
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'ryadav@kloudrac.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'kloudracrajesh'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("ryadav@kloudrac.com", "SMS"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}


/*Mail Function for Contact Us.*/
function sendContactUsMail($sub,$msg,$to)
{      
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'zuhed123@gmail.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'Test@123'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("no-reply@babysitter.com", "BabySitter"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}



// Function for when babysitter Accept/Reject invitation of Parent.. 
function sendInvitationMail($sub,$msg,$to)
{ 

     
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'zuhed123@gmail.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'Test@123'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("no-reply@babysitter.com", "Babysitter"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}


// Function for when babysitter Accept/Reject invitation of Parent.. 
function sendSitterInvitationMail($sub,$msg,$to)
{ 

     
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'zuhed123@gmail.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'Test@123'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("no-reply@babysitter.com", "Babysitter"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}


/*Function is used for sending mail when parent is send invitation to sitter.*/
function sendParentInvitationMail($sub,$msg,$to)
{      
      $mail   = new PHPMailer; // call the class
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com'; // platinum.waxspace.com Hostname of the mail server
      $mail->Port = '465'; //Port of the SMTP like to be 25, 80, 465 or 587
      $mail->SMTPAuth = true; //Whether to use SMTP authentication
      $mail->Username = 'zuhed123@gmail.com'; //Username for SMTP authentication any valid email created in your domain
      $mail->Password = 'Test@123'; //Password for SMTP authentication
      //$mail->AddReplyTo("admin@quiconnaitunbon.com.com", "Admin"); //reply-to address
      $mail->SetFrom("no-reply@babysitter.com", "BabySitter"); //From address of the mail
      // put your while loop here like below,
      $mail->Subject = $sub; //Subject od your mail
      
   // print_r($msg);die;
  
    $mail->AddAddress($to);
    $mail->MsgHTML($msg); //Put your body of the message you can place html code here
    $mail->isHTML(true);
    /*echo"<pre>";
    print_r($mail);die;*/
    $send = $mail->Send(); //Send the mails
      
      if($send)
        return "send";
      else
    return "Not Send";
}


?>
