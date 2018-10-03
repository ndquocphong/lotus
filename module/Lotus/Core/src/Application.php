<?php
namespace Lotus\Core;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class Application
{
    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();

        $response = new Response();
        $response->getBody()->write('hello world');


        echo $response->getBody();
    }
}