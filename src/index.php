<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

// dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// ig api
require_once 'Ig_Api/Ig_Api_Context.php';
require_once 'Ig_Api/Http_Client.php';
use Ig_Api\Ig_Api_Context;
use Ig_Api\Http_Client;

//*************************************
// Const
//*************************************
define('APP_ACCESS_TOKEN', $_ENV['FB_APP_ACCESS_TOKEN']);

//*************************************
// Function
//*************************************
function searchHashtag($name)
{
    // Initialize Ig api
    $api = new Ig_Api_Context(new Http_Client(), APP_ACCESS_TOKEN);

    // Get user pages id for facebook pages
    $pages_id = $api->getUserPagesId();
    if (isset($pages_id->error)) {
        $api->printJson($pages_id);
        return null;
    }
    //echo $pages_id;

    // Get user id for instagram business account
    $user_id = $api->getIgUserId($pages_id);
    if (isset($user_id->error)) {
        $api->printJson($user_id);
        return null;
    }
    //echo $user_id;

    // Get hashtag id in instagram by hashtag name
    $hashtag_id = $api->searchHashtagId($user_id, $name);
    if (isset($hashtag_id->error)) {
        $api->printJson($hashtag_id);
        return null;
    }
    //echo $hashtag_id;

    // Get recent medias that has specific hashtag in instagram by hashtag id
    $medias = $api->getRecentMediasByHashtag($user_id, $hashtag_id);
    if (isset($medias->error)) {
        $api->printJson($medias);
        return null;
    }
    //$api->printJson($medias);

    return $medias;
}

// For DEBUG
function printJson($json)
{
    echo '<pre>';
    echo json_encode($json, JSON_PRETTY_PRINT);
    echo '</pre>';
}

//*************************************
// Main
//*************************************
$result = searchHashtag('hello');
if (isset($result)) {
    printJson($result);
}
