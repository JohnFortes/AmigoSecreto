<?php

use Slim\Factory\AppFactory;

session_start();

require_once("vendor/autoload.php");


$app = AppFactory::create();

require_once("site.php");

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->run();