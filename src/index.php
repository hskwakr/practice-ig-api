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
function sendRequest($query)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $query);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response);
}

// For DEBUG
function printJson($json)
{
    echo '<pre>';
    echo json_encode($json, JSON_PRETTY_PRINT);
    echo '</pre>';
}

function getUserPages()
{
    $endpoint = '/me/accounts?';
    $options =
        'access_token=' . APP_ACCESS_TOKEN;

    $query = FB_API_BASE . $endpoint . $options;
    //echo $query;
    return sendRequest($query);
}

function getIgUser($pageId)
{
    $endpoint = '/' . $pageId . '?';
    $options =
        'access_token=' . APP_ACCESS_TOKEN .
        '&fields=instagram_business_account';

    $query = FB_API_BASE . $endpoint . $options;
    //echo $query;
    return sendRequest($query);
}

function getIgMedia($userId)
{
    $endpoint = '/' . $userId . '/media?';
    $options =
        'access_token=' . APP_ACCESS_TOKEN;

    $query = FB_API_BASE . $endpoint . $options;
    //echo $query;
    return sendRequest($query);
}


function searchHashtag($userId, $hashtag)
{
    $endpoint = '/ig_hashtag_search?';
    $options =
        'access_token=' . APP_ACCESS_TOKEN .
        '&user_id=' . $userId .
        '&q=' . $hashtag;

    $query = FB_API_BASE . $endpoint . $options;
    //echo $query;
    return sendRequest($query);
}

function getRecentMediasByHashtag($userId, $hashtagId)
{
    $endpoint = '/' . $hashtagId . '/recent_media?';
    $options =
        'access_token=' . APP_ACCESS_TOKEN .
        '&user_id=' . $userId .
        '&fields=media_type,media_url,permalink';

    $query = FB_API_BASE . $endpoint . $options;
    //echo $query;
    return sendRequest($query);
}

//*************************************
// Main
//*************************************

// Initialize Ig api
$api = new Ig_Api(new Http_Client(), APP_ACCESS_TOKEN);

// get the user's pages
$userPages = getUserPages();
//printJson($userPages);

// capture the page id
$pageId = $userPages->data[0]->id;
//echo $pageId;

// get the page's instagram business account
$igUser = getIgUser($pageId);
//printJson($igUser);

// capture the connected ig user id
$igUserId = $igUser->instagram_business_account->id;
//echo $igUserId;

// get the instagram business account's media objects
//$igMedias = getIgMedia($igUserId);
//printJson($igMedias);

// search the post by hashtag name
$igHashtagContext = searchHashtag($igUserId, 'b3d');
printJson($igHashtagContext);

// capture the hashtag id
//$igHashtagId = $igHashtagContext->data[0]->id;
//echo $igHashtagId;

// get the recent medias by hashtag id
//$igMedias = getRecentMediasByHashtag($igUserId, $igHashtagId);
//printJson($igMedias);
