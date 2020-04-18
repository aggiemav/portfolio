<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
/* $name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
 */
$name = strip_tags(htmlspecialchars($_POST['name']));
$visitor_email = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// echo $name;
// echo $visitor_email;
// echo $message;

//Validate first
 if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
} 

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'andrea@afelder.com';
$email_subject = "New Form submission";
$email_body = "You have received a new message from the user $name.\n". 
    "Email: $visitor_email\n".
    "Phone: $phone\n".
    "Here is the message:  \n $message\n". 
    
$to = "andrea@afelder.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: thank-you.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 