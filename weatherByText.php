<?php
// make twilio/sdk and paragonie/easydb available 
require_once "vendor/autoload.php";
// make $database available
require_once "../database.inc.php";
// make $sid and $token available
require_once "../twilio.inc.php";
require_once "weather.class.php";

use Twilio\Twiml;

$weather = new WEATHER($database);

$response = new Twiml;
$response->say("Hello World!");

header("content-type: text/xml");
echo $response;

?>
