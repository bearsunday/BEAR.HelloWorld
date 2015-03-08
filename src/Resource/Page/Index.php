<?php

namespace BEAR\HelloWorld\Resource\Page;

use BEAR\Package\Annotation\Etag;
use BEAR\RepositoryModule\Annotation\QueryRepository;
use BEAR\Resource\ResourceObject;

/**
 * @QueryRepository
 * @Etag
 */
class Index extends ResourceObject
{
    public function onGet($name = 'BEAR.Sunday')
    {
        $this->body['greeting'] = 'Hello ' . $name;

        return $this;
    }
}
