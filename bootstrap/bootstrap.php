<?php

/**
 * @global string $context
 */
namespace BEAR\HelloWorld;

use BEAR\Package\Bootstrap;
use BEAR\Resource\ResourceObject;
use Doctrine\Common\Annotations\AnnotationRegistry;

load: {
    $loader = require dirname(__DIR__) . '/vendor/autoload.php';
    AnnotationRegistry::registerLoader([$loader, 'loadClass']);
}


route: {
    /** @var $app \BEAR\Sunday\Extension\Application\AbstractApp */
    $app = (new Bootstrap)->getApp(__NAMESPACE__, $context);
    $request = $app->router->match($GLOBALS, $_SERVER);
}

try {
    /** @var $page \BEAR\Resource\Request */
    $page = $app->resource
        ->{$request->method}
        ->uri($request->path)
        ->withQuery($request->query)
        ->eager
        ->request();

    // representation transfer
    /* @var $page ResourceObject */
    $page->transfer($app->responder, $_SERVER);
    exit(0);
} catch (\Exception $e) {
    $app->error->handle($e, $request)->transfer();
}
