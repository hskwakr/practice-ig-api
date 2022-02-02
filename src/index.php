<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

// dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// ig api
require_once 'Ig_Api/Ig_Api.php';
use Ig_Api\Ig_Api;

//*************************************
// Const
//*************************************
define('APP_ACCESS_TOKEN', $_ENV['FB_APP_ACCESS_TOKEN']);

//*************************************
// Function
//*************************************
function searchHashtag($name)
{
    try {
        // Initialize Ig api
        $api = new Ig_Api(APP_ACCESS_TOKEN);
        // get medias
        $res = $api->init()->searchHashtag($name);
        return $res->recent_medias;
    } catch (Exception $e) {
        echo $e->__toString();
        return null;
    }
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
$data = searchHashtag('hello');
if (isset($data)) {
    printJson($data);
}
