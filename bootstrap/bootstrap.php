<?php

/**
 * @global string $context
 */
namespace BEAR\HelloWorld;

use BEAR\AppMeta\AppMeta;
use BEAR\Package\Bootstrap;
use BEAR\QueryRepository\HttpCache;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Provide\Transfer\HttpResponder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ApcCache;

load: {
    $loader = require dirname(__DIR__) . '/vendor/autoload.php';
    AnnotationRegistry::registerLoader([$loader, 'loadClass']);
}

http_cache: {
    $httpCache = new HttpCache(__NAMESPACE__ ,$_SERVER);
    if ($httpCache()) {
        exit(0);
    }
}

route: {
    /** @var $app \BEAR\Sunday\Extension\Application\AbstractApp */
    $app = (new Bootstrap)->newApp(new AppMeta(__NAMESPACE__), $context, new ApcCache);
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
    $page->transfer($httpCache->responder, $_SERVER);
    exit(0);
} catch (\Exception $e) {
    $app->error->handle($e, $request)->transfer();
    exit(1);
}
