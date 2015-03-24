<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;

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