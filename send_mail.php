<?php
require 'vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

session_start();

// Load credentials
$client = new Client();
$client->setApplicationName('Gmail API PHP Form');
$client->setScopes(Gmail::GMAIL_SEND);
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');

// Path to store token
$tokenPath = 'token.json';

if (isset($_POST['submit'])) {  // Form submitted
    $name = $_POST['name'];
    $sender_email = $_POST['sender_email'];
    $subject = $_POST['subject'];
    $body = $_POST['message'];

    // Load previously authorized token if exists
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If no valid token or expired, redirect to auth
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
            exit;
        }
        // Save new token
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }

    // Create MIME message
    $mime = "From: $name <$sender_email>\r\n";
    $mime .= "To: nokuthulamargaret@gmail.com.com\r\n";  // Change to your recipient
    $mime .= "Subject: $subject\r\n";
    $mime .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
    $mime .= $body;

    $raw = base64url_encode($mime);

    $message = new Message();
    $message->setRaw($raw);

    try {
        $service = new Gmail($client);
        $service->users_messages->send('me', $message);
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Helper function for base64url encoding
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
?>