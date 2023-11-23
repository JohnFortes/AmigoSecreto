<?php

use AmigoSecreto\Controller\SiteController;

$app->get('/', [SiteController::class, 'indexSite']);