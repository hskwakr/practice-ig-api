<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//*************************************
// Declaration
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

//*************************************
// Main
//*************************************

// get the user's pages
$userPages = getUserPages();
//printJson($userPages);

// capture the page id
$pageId = $userPages->data[0]->id;
//echo $pageId;

$igUser = getIgUser($pageId);
//printJson($igUser);

$igUserId = $igUser->instagram_business_account->id;
//echo $igUserId;
