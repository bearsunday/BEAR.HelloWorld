<?php

namespace BEAR\HelloWorld\Resource\Page;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;

/**
 * @Cacheable
 */
class Index extends ResourceObject
{
    public $body = ['greeting' => 'Hello BEAR'];

    public function onGet()
    {
        return $this;
    }

    public function onPost($name)
    {
        $this->code = 201;
        $this->body['greeting'] = 'Post ' . $name;

        return $this;

    }

    public function onPut($name)
    {
        $this->code = 202;
        $this->body['greeting'] = 'Put ' . $name;

        return $this;

    }
}
