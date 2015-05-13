<?php
namespace TheStephensHQ;
class Config{
    public function mailgun_config(){
        return array(
            'key' => 'key-8e6dc7d05371e2374e3f8f8484dc41d2',
            'domain' => 'sandbox4b98ecdeed50474d887a6033b5ba144d.mailgun.org'
        );
    }
    public function db_connect($localhost, $user, $pwd, $db_name){
        $link = mysqli_connect($localhost, $user, $pwd, $db_name);
        if (!$link) {
            die('Could not connect: ' . mysql_error());
        }
        echo 'Connected successfully';
        mysql_close($link);
    }
}
