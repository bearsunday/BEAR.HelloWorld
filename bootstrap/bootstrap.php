<?php

/**
 * @global string $context
 */
namespace BEAR\HelloWorld;

use BEAR\AppMeta\AppMeta;
use BEAR\Package\Bootstrap;
use BEAR\Package\Provide\Transfer\Http304;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ApcCache;

load: {
    $dir = dirname(__DIR__);
    $loader = require $dir . '/vendor/autoload.php';
    AnnotationRegistry::registerLoader([$loader, 'loadClass']);
}

http304: {
    if ((new Http304)->isNotModified(__NAMESPACE__ , $_SERVER)) {
        http_response_code(304);
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
        ->request();

    // representation transfer
    $page()->transfer($app->responder, $_SERVER);
    exit(0);
} catch (\Exception $e) {
    $app->error->handle($e, $request)->transfer();
    exit(1);
}
