<?php
    // My modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    //print '<pre>'; print_r($_REQUEST); print_r($_POST); print_r($_GET); print '</pre>';


     $fullname = strip_tags(trim($_REQUEST['txtfname'])) . ' ' . strip_tags(trim($_REQUEST['txtlname']));
     $custemail = strip_tags(trim($_REQUEST['txtemail']));
     $mobile = strip_tags(trim($_REQUEST['txtmobile']));
     $address1 = strip_tags(trim($_REQUEST['txtaddress1']));
     $address2 = strip_tags(trim($_REQUEST['txtaddress2']));
     $pin = strip_tags(trim($_REQUEST['txtpin']));
     $date = strip_tags(trim($_REQUEST['txtdate']));
     $time = strip_tags(trim($_REQUEST['txttime']));
     $services = $_REQUEST['chk'];

     //print_r($services);

     $toemail = 'sakina@missbeautiful.co.in';
     //$toemail = 'viral@sunrisesoftlab.com';
     $subject = 'New Booking from ' . $fullname;

     $header = "From: " . $fullname . " <" . $custemail . "> \r\n";
     $header .= "MIME-Version: 1.0\r\n";
     $header .= "Content-type: text/html\r\n";

     $message = "<b>Full Name: </b>" . $fullname . "<br />";
     $message .= "<b>Mobile No: </b>" . $mobile . "<br />";
     $message .= '<b>Address: </b>'  . $address1 . "<br />";
     $message .= $address2 . "<br />";
     $message .= '<b>Pin Code: </b>' . $pin . "<br />";
     $message .= '<b>Date: </b>' . $date . "<br />";
     $message .= '<b>Time: </b>' . $time . "<br />";
     $message .= '<h2>Services Required</h2>';
     $message .= '<ul>';
     foreach ($services as $value) {
       $message .= '<li>' . $value . '</li>';
     }
     $message .= '</ul>';


      // Send the email.
      if (mail($toemail, $subject, $message, $header)) {
          // Set a 200 (okay) response code.
          http_response_code(200);
          echo "Thank You! Your message has been sent.";
      } else {
          // Set a 500 (internal server error) response code.
          http_response_code(500);
          echo "Oops! Something went wrong and we couldn't send your message.";
      }

      // [txtfname] => viral
      // [txtlname] => mehta
      // [txtemail] => viral007in@gmail.com
      // [txtmobile] => 
      // [txtaddress1] => 
      // [txtaddress2] => 
      // [txtpin] => 
      // [txtdate] => 
      // [txttime] => 10:00 AM     

?>