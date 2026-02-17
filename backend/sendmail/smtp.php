<?php
$to = "nokuthulamargaret@gmail.com";
$subject = "My Subject";
$message = "Hello world! This is a simple email message.";
$headers = "From: nokuthulamargaret@gmail.com" . "\r\n";
// Additional headers can be added for CC, BCC, etc.

// Send the email and check for success/failure
if (mail($to, $subject, $message, $headers)) {
    echo "Message sent successfully...";
} else {
    echo "Message could not be sent...";
}
?>