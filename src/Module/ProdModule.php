<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\HelloWorld\Module;

use BEAR\RepositoryModule\Annotation\Storage;
use BEAR\Resource\Annotation\LogicCache;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class ProdModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(Cache::class)->to(ApcCache::class)->in(Scope::SINGLETON);
        $this->bind(Reader::class)->toConstructor(
            CachedReader::class,
            'reader=annotation_reader'
        );
        $this->bind(Reader::class)->annotatedWith('annotation_reader')->to(AnnotationReader::class);
        $this->bind(CacheProvider::class)->annotatedWith(Storage::class)->to(ApcCache::class)->in(Scope::SINGLETON);
        $this->bind(Cache::class)->annotatedWith(LogicCache::class)->to(ApcCache::class)->in(Scope::SINGLETON);
        $this->bind(Cache::class)->annotatedWith(Storage::class)->to(ApcCache::class)->in(Scope::SINGLETON);
    }
}
