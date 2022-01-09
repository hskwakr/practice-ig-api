<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// .env
$APP_ID = $_ENV['FB_APP_ID'];
$APP_SECRET = $_ENV['FB_APP_SECRET'];
$REDIRECT_URI = $_ENV['FB_REDIRECT_URI'];

$creds = array(
    'app_id' => $APP_ID,
    'app_secret' => $APP_SECRET,
    'default_graph_version' => 'v12.0',
    'persistent_data_handler' => 'session'
);

// create facebook object
$facebook = new Facebook\Facebook($creds);

// helper
$helper = $facebook->getRedirectLoginHelper();

// outh object
$outhClient = $facebook->getOAuth2Client();

if (isset($_GET['code'])) {
    // get the access token
} else {
    // display login url
    $permissions = [
        'public_profile',
        'instagram_basic',
        'pages_show_list',
    ];
    $loginUrl = $helper->getLoginUrl($REDIRECT_URI, $permissions);

    echo '<a href="' . $loginUrl . '">
       Login with Facebook 
    </a>';
}
