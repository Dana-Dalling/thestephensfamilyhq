<?php
//load site config
require 'config.php';
//load mailgun php API
require '../vendor/mailgun/mailgun-php/src/Mailgun/Mailgun.php';

use TheStephensHQ\Config;
use \Mailgun;


//instantiate mailgun and the site config
$stephenshq_config = new TheStephensHQ\Config();
$mailgun_config = $stephenshq_config->mailgun_config();
/*
$mgClient = new Mailgun($mailgun_config['key']);
$domain = $mailgun_config['domain'];

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
    array('from'    => 'TheStephensHQ Bot <system@thestephenshq.com>',
        'to'      => 'Fabion Stephens <fabion@octobits.io>',
        'subject' => 'Hello Fabion Stephens',
        'text'    => 'Congratulations Fabion Stephens, you just sent an email with Mailgun!  You are truly awesome!  You can see a record of this email in your logs: https://mailgun.com/cp/log .  You can send up to 300 emails/day from this sandbox server.  Next, you should add your own domain so you can send 10,000 emails/month for free.'));
*/
//make the success state set as false by default
$success_state = false;
$response_msg = '';

//check if a rsvp was entered
if($_POST['rsvp_code'] != ''){
    $success_state = true;
}else{
  $response_msg = 'You must enter a valid RSVP code';
}

//TODO: check rsvp code via database

//build the response
$response = array(
    'success' => $success_state,
    'message' => $response_msg
);

//return the response as a JSON object
print json_encode($response);