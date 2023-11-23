<?php

namespace AmigoSecreto\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use psr\Http\Message\ResponseInterface as Response;

class SiteController
{
    public function indexSite(Request $request, Response $response, $args)
    {
        die('Index');
    }
}