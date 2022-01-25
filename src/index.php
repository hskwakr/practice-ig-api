<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

// dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// ig api
require_once 'Ig_Api/Ig_Api.php';
require_once 'Ig_Api/Http_Client.php';
use Ig_Api\Ig_Api;
use Ig_Api\Http_Client;

//*************************************
// Const
//*************************************
define('APP_ID', $_ENV['FB_APP_ID']);
define('APP_SECRET', $_ENV['FB_APP_SECRET']);
define('APP_ACCESS_TOKEN', $_ENV['FB_APP_ACCESS_TOKEN']);
define('REDIRECT_URI', $_ENV['FB_REDIRECT_URI']);

define('FB_API_BASE', 'https://graph.facebook.com/v12.0');

//*************************************
// Function
//*************************************

//*************************************
// Main
//*************************************

// Initialize Ig api
$api = new Ig_Api(new Http_Client(), APP_ACCESS_TOKEN);

$pages_id = $api->getUserPagesId();
if (isset($pages_id->error)) {
    $api->printJson($pages_id);
} else {
    //echo $pages_id;
    $user_id = $api->getIgUserId($pages_id);

    if (isset($user_id->error)) {
        $api->printJson($user_id);
    } else {
        //echo $user_id;
        $hashtag_id = $api->searchHashtagId($user_id, 'b3d');

        if (isset($hashtag_id->error)) {
            $api->printJson($hashtag_id);
        } else {
            //echo $hashtag_id;
            $medias = $api->getRecentMediasByHashtag($user_id, $hashtag_id);

            if (isset($medias->error)) {
                $api->printJson($medias);
            } else {
                $api->printJson($medias);
            }
        }
    }
}
