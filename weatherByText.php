<?php
// make twilio/sdk and paragonie/easydb available
require_once "vendor/autoload.php";
// make $database available
require_once "../database.inc.php";
// make $sid and $token available
require_once "../twilio.inc.php";
require_once "weather.class.php";
$weather = new WEATHER($database);

use Twilio\Twiml;
$response = new Twiml;
use Twilio\Rest\Client;
$client = new Client($sid, $token);

$text_body = trim($_REQUEST['Body']);
$twilio_service_number = trim($_REQUEST['To']);
$twilio_client_number = trim($_REQUEST['From']);
$twilio_message_id = trim($_REQUEST['MessageSid']);
$twilio_account_id = trim($_REQUEST['AccountSid']);
$twilio_zip_code_guess = trim($_REQUEST['FromZip']);

/*
wanted features: user signup with once-yearly subscription fee of $12.
trigger-able alerts: high above temp or low below temp. trigger on rain chance above 25%.
alerts in morning or afternoon or both; allow user configuration of when morning/afternoon are.
*/
$userCount = $weather->checkUserByPhone($twilio_client_number);

//if ($text_body == 'SIGNUP') {
switch($userCount) {
	case 0:
		$weather->makeNewUser($twilio_client_number);
		$response->sms('What zip code do you want to receive weather for?');
	case 1:
		$user = $weather->getUserByPhone($twilio_client_number);
		if ($user['active'] == 1) {
			$response->sms('You already have an active account!');
		} else {
			if (is_numeric($body))
			{
				$weather->addZip($twilio_client_number, $body);
				$response->sms('Weather by text now active for '.$body);
			}
		}
	default:
		// error error problem problem
}
//}

if ($text_body == 'STOP') {
	// do something smart that nukes their account from our system, stops any payments, and sends them a `sorry to see you go` message, not necessarily in that order.
}
if ($text_body == 'START') {
	// re-enable their account. figure out how to make them continue to pay.
}

?>
