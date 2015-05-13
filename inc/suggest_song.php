<?php
require 'config.php';
use TheStephensHQ\Config;
$stephenshq_config = new TheStephensHQ\Config();
$stephenshq_config->db_connect('localhost','thesteph_dev','devdbpass!876','thesteph_basedb');