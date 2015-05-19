<?php
//load site config
require 'config.php';
require '../vendor/autoload.php';
use Mailgun\Mailgun;

use TheStephensHQ\Config;


//instantiate mailgun and the site config
$stephenshq_config = new TheStephensHQ\Config();
$mailgun_config = $stephenshq_config->mailgun_config();

$suggested_by = $_POST['name'];
$song_title = $_POST['song_title'];
$artist = $_POST['artist'];

//ensure these fields are not empty
if($song_title != '' && $artist != '' && $suggested_by != ''){
    $suggestion = array($_POST['song_title'], $_POST['artist'], $_POST['name']);
    $fp = fopen('suggested_songs.csv', 'a');
    fputcsv($fp, $suggestion);
    fclose($fp);
    $response = array(
        'type' => 'success',
        'message' => 'Thank you so much! Hope to see you getting down to this song!',
        'clear_form_id' => 'suggest-song'
    );
    //instantiate mailgun and the site config
    $stephenshq_config = new TheStephensHQ\Config();
    $mailgun_config = $stephenshq_config->mailgun_config();

$mgClient = new Mailgun($mailgun_config['key']);
$domain = $mailgun_config['domain'];

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
    array('from'    => 'TheStephensHQ Bot <system@thestephenshq.com>',
        'to'      => 'dana@thestephenshq.com, fabion@thestephenshq.com',
        'subject' => 'New Song Suggestion',
        'html'    =>
        '
            <div style="color: #8E8E8E">
                <div style="border-bottom:1px solid #ddd;margin-bottom: 8px;padding-bottom: 8px;">Hi guys!</div>
                <div>'.$suggested_by.' has just suggested a song:</div>
                <div style="margin-bottom:16px;"><strong>'.$song_title.'</strong> by '.$artist.'</div>
                <div>The song list have been updated and can be downloaded here:</div>
                <div>http://thestephenshq.com/inc/suggested_songs.csv</div>
                <div style="border-top:1px solid #ddd;margin-top: 32px;padding-top: 8px;">Keep Awesome!</div>
                <div>Bot</div>
            </div>
        '));

}else{
    //build the response
    $missing_song_title = $_POST['song_title'] != '' ? false : true;
    $missing_artist = $_POST['artist'] != '' ? false : true;
    $missing_name = $_POST['name'] != '' ? false : true;
    $response = array(
        'type' => 'error',
        'message' => 'Please ensure you fill out all fields',
        'missing_song_title' => $missing_song_title,
        'missing_artist' => $missing_artist,
        'missing_name' => $missing_name
    );
}
//return the response as a JSON object
print json_encode($response);
