<?php

namespace BEAR\HelloWorld\Resource\Page;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = clone $GLOBALS['RESOURCE'];
    }

    public function testGet()
    {
        $page = $this->resource->get->uri('page://self/index')->eager->request();
        $this->assertSame(200, $page->code);
        $this->assertSame('Hello BEAR', $page['greeting']);

        return $page;
    }

    public function testPut()
    {
        $page = $this->resource->put->uri('page://self/index')->withQuery(['name' => 'Kuma'])->eager->request();
        $this->assertSame(202, $page->code);
        $this->assertSame('Put Kuma', $page['greeting']);
    }

    /**
     * @depends testGet
     */
    public function testView($page)
    {
        $json = json_decode((string) $page);
        $this->assertNotTrue(json_last_error());
        $this->assertInstanceOf('stdClass', $json);
        $this->assertSame('Hello BEAR', $json->greeting);
    }

}
