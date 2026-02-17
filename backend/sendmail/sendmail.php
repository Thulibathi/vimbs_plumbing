<?php

// IMPORTANT: Change this to YOUR real email address
$to = "yourname@gmail.com";  

if (isset($_POST['submit'])) {

    // Get data from form (and do very basic cleaning)
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'Contact form message');
    $message = trim($_POST['message'] ?? '');

    // Very basic validation
    if (empty($name) || empty($email) || empty($message)) {
        die("<div class='message error'>Please fill in all required fields.</div>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<div class='message error'>Invalid email format.</div>");
    }

    // Build email content
    $email_body = "You received a new message:\n\n";
    $email_body .= "Name:    $name\n";
    $email_body .= "Email:   $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    // Headers
    $headers = "From: $name <$email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    // Try to send
    if (mail($to, $subject, $email_body, $headers)) {
        echo "<div class='message success'>Thank you! Your message has been sent successfully.</div>";
    } else {
        echo "<div class='message error'>Sorry, message could not be sent. Please try again later.</div>";
    }

} else {
    // Someone opened sendmail.php directly → not allowed
    echo "<div class='message error'>Invalid request.</div>";
}

?>

<!-- Optional: link back -->
<p><a href="contact.html">← Back to form</a></p>