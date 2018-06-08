<?php
namespace HalimonAlexander\Registry\Test;

use HalimonAlexander\Registry\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    /** @var Registry */
    private $registry;

    public function setUp()
    {
        $this->registry =
            (new Registry())
            ->set('a', 1)
            ->set('b', 2)
            ->set('c', ["1" => "a"]);
    }

    public function testHas()
    {
        $this->assertTrue($this->registry->has('a'));
        $this->assertTrue($this->registry->has('b'));
        $this->assertFalse($this->registry->has('d'));
        $this->assertFalse($this->registry->has('123'));
    }

    public function testGet()
    {
        $this->assertEquals(1, $this->registry->get('a'));
        $this->assertEquals(["1" => "a"], $this->registry->get('c'));
        $this->assertEquals('abc', $this->registry->get('na-key', 'abc'));
    }

    public function testSet()
    {
        $this->assertFalse($this->registry->has("abcd"));
        $this->assertNull($this->registry->get("abcd"));

        $this->registry->set('abcd', 1234);

        $this->assertTrue($this->registry->has('abcd'));
        $this->assertEquals(1234, $this->registry->get('abcd'));
    }
}
