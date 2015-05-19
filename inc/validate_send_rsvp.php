<?php
//load site config
require 'config.php';
require '../vendor/autoload.php';
use Mailgun\Mailgun;

use TheStephensHQ\Config;

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$rsvped_for = $_POST['rsvped_for'];

if($rsvped_for == 'not-attending'){
    $rsvped_event = 'Not Be Attending';
}elseif($rsvped_for == 'all'){
    $rsvped_event = 'Be attending all events';
}else{
    $rsvped_event = 'Be attending the '.ucwords($rsvped_for).' only';
}

if($first_name != '' || $last_name != ''){
    $rsvp_details = array($first_name, $last_name, $rsvped_event);
    $fp = fopen('rsvp_list.csv', 'a');
    fputcsv($fp, $rsvp_details);
    fclose($fp);
    $response = array(
        'type' => 'success',
        'message' => 'Thank you so much for your response!',
        'clear_form_id' => 'rsvp-form'
    );
    //instantiate mailgun and the site config
    $stephenshq_config = new TheStephensHQ\Config();
    $mailgun_config = $stephenshq_config->mailgun_config();

    $mgClient = new Mailgun($mailgun_config['key']);
    $domain = $mailgun_config['domain'];

# Make the call to the client.
    $result = $mgClient->sendMessage("$domain",
        array('from'    => 'TheStephensHQ Bot <system@thestephenshq.com>',
            'to'      => 'f.o.stephens@gmail.com',
            'subject' => 'New RSVP confirmation',
            'html'    =>
            '
                <div style="color: #8E8E8E">
                    <div style="border-bottom:1px solid #ddd;margin-bottom: 8px;padding-bottom: 8px;">Hi guys!</div>
                    <div>'.$first_name.' '.$last_name.' has just rsvped and will:</div>
                <div style="margin-bottom:16px;"><strong>'.$rsvped_event.'!</strong></div>
                <div>The RSVP list have been updated and can be downloaded here:</div>
                <div>http://thestephenshq.com/inc/rsvp_list.csv</div>
                <div style="border-top:1px solid #ddd;margin-top: 32px;padding-top: 8px;">Keep Awesome!</div>
                <div>Bot</div>
            </div>
        '));

}else{

    //build the response
    $missing_first_name = $_POST['first_name'] != '' ? false : true;
    $missing_last_name = $_POST['last_name'] != '' ? false : true;
    $response = array(
        'type' => 'error',
        'message' => 'Please ensure you fill out all fields',
        'missing_first_name' => $missing_first_name,
        'missing_last_name' => $missing_last_name,
    );
}
//return the response as a JSON object
print json_encode($response);