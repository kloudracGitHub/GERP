  <?php 
  include "classes/class.phpmailer.php"; // include the class file name
	  
function sendMail($to)
{ 

    
      $mail   = new PHPMailer;
      $mail->IsSMTP();
      $mail->SMTPSecure = "SSL";

      $mail->SMTPDebug  = 0;  
      $mail->Host = 'ssl://smtp.gmail.com';
      $mail->Port = '465';
      $mail->SMTPAuth = true; 
      $mail->Username = 'aishsharmaggm@gmail.com'; 
      $mail->Password = '9826291003';
      $mail->SetFrom("no-reply@sourceInvoice.com", "sourceInvoice"); 
      $mail->Subject = 'fdgdghdhjfhjfhjhj';
      $mail->AddAddress($to);
      $mail->Subject  = "Subject";
      $body= "Hi!<br>Hi! again";
      $mail->MsgHTML($body);   
      $mail->AddAttachment('images/attach/tutorial.pdf'); // attachment
      if(!$mail->Send()) {
          echo 'Message was not sent.';
          echo 'Mailer error: ' . $mail->ErrorInfo;
      } else {
          echo 'Message has been sent.';
      }
     
}

// require_once 'lib/swift_required.php';

// // Create the mail transport configuration
// $transport = Swift_MailTransport::newInstance();

// // Create the message
// $message = Swift_Message::newInstance();
// $message->setTo(array(
//   "khushiudaan@gmail.com" => "Aurelio De Rosa",
//   // "test@fake.com" => "Audero"
// ));
// $message->setSubject("This email is sent using Swift Mailer");
// $message->setBody("You're our best client ever.");
// $message->setFrom("anu.kumari@udaantechnologies.info", "Your bank");

// // Send the email
// $mailer = Swift_Mailer::newInstance($transport);
// $mailer->send($message);



// Now you only need to add the necessary stuff
 
// HTML body
 

 
// And the absolute required configurations for sending HTML with attachement
 




?>
