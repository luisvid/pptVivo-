<?php
$configurator = Configurator::getInstance ();

define('APP_ID', $configurator->getFacebookAppId());
define('APP_SECRET', $configurator->getFacebookAppSecret());