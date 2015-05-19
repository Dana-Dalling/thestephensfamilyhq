<?php
require '../vendor/autoload.php';
use Mailgun\Mailgun;

use TheStephensHQ\Config;


//instantiate mailgun and the site config
$stephenshq_config = new TheStephensHQ\Config();
$mailgun_config = $stephenshq_config->mailgun_config();