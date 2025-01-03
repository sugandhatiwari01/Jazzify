<?php
session_start();
require_once 'vendor/autoload.php';

// Initialize Google Client
$client = new Google_Client();
$client->setApplicationName('Jazzify');
$client->setRedirectUri('http://localhost/jazzify/Jazzify/main.html'); // Callback URL
$client->setAuthConfig('cred.json'); // Path to Google API credentials file
$client->setAccessType('offline');
$client->setPrompt('select_account');
$client->addScope('https://www.googleapis.com/auth/userinfo.email');
$client->addScope('https://www.googleapis.com/auth/userinfo.profile');

// Check if an authorization code is provided
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    try {
        // Fetch access token using the authorization code
        $access_token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($access_token['access_token'])) {
            $_SESSION['access_token'] = $access_token;

            // Store refresh token if available
            if (isset($access_token['refresh_token'])) {
                $_SESSION['refresh_token'] = $access_token['refresh_token'];
            }

            $client->setAccessToken($access_token);
            // Redirect to main page after successful login
            header('Location: main.html');
            exit();
        } else {
            // Handle access token retrieval failure
            echo "<script>alert('Failed to retrieve access token. Please try again.'); window.location.href='login.php';</script>";
            exit();
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>alert('Error during Google sign-in. Please try again.'); window.location.href='login.php';</script>";
        exit();
    }
}

// Check if a valid access token exists
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);

    if ($client->isAccessTokenExpired()) {
        try {
            // Refresh token if access token has expired
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $_SESSION['access_token'] = $client->getAccessToken();
            } else {
                // Redirect to Google's sign-in page if refresh token is unavailable
                header('Location: ' . $client->createAuthUrl());
                exit();
            }
        } catch (Exception $e) {
            echo "<script>alert('Error refreshing token. Please try again.'); window.location.href='login.php';</script>";
            exit();
        }
    }

    // Access user information
    $service = new Google_Service_Oauth2($client);
    $user = $service->userinfo->get();
    echo 'Hello ' . $user->getName();
} else {
    // Redirect directly to Google's sign-in page if no valid session exists
    header('Location: ' . $client->createAuthUrl());
    exit();
}
?>
