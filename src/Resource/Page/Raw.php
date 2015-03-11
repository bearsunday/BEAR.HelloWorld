<?php

namespace BEAR\HelloWorld\Resource\Page;

use BEAR\Package\Annotation\Etag;
use BEAR\Resource\ResourceObject;

/**
 * @Etag
 */
class Raw extends ResourceObject
{
    public $body = ['greeting' => 'Hello BEAR'];

    public function onGet()
    {
        return $this;
    }

    public function onPut($name)
    {
        $this->code = 201;
        $this->body['greeting'] = 'Put ' . $name;

        return $this;

    }
}
