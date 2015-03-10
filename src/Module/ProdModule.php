<?php

namespace BEAR\HelloWorld\Module;

use BEAR\RepositoryModule\Annotation\Storage;
use BEAR\Package\Context\ProdModule as PackageProdModule;
use Doctrine\Common\Cache\Cache;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

use Doctrine\Common\Cache\ApcCache;

class ProdModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // configure shared storage for query repository
        $cache = ApcCache::class;
        $this->bind(Cache::class)->annotatedWith(Storage::class)->to($cache)->in(Scope::SINGLETON);

        $this->install(new PackageProdModule);
    }
}
