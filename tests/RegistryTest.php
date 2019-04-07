<?php

namespace HalimonAlexander\Registry\Test;

use HalimonAlexander\Registry\RegistryInterface;
use HalimonAlexander\Registry\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    /** @var Registry */
    private $registry;

    public function setUp(): void
    {
        $this->registry =
            (Registry::getInstance())
                ->set('a', 1)
                ->set('b', 2)
                ->set('c', ["1" => "a"]);
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::getInstance()
     */
    public function testInstance()
    {
        $this->assertInstanceOf(RegistryInterface::class, $this->registry);
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::get()
     */
    public function testGetEmptyKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->get('');
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::has()
     */
    public function testHasEmptyKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->has('');
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::set()
     */
    public function testSetEmptyKey()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->set('', 123);
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::get()
     */
    public function testGet()
    {
        $this->assertEquals(1, $this->registry->get('a'));
        $this->assertEquals(["1" => "a"], $this->registry->get('c'));
        $this->assertEquals('abc', $this->registry->get('na-key', 'abc'));
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::getByClassname()
     */
    public function testGetByClassname()
    {
        $this->assertNull($this->registry->getByClassname('RuntimeException'));

        $this->registry->set('error', new \RuntimeException());
        $this->assertInstanceOf(\RuntimeException::class, $this->registry->getByClassname('RuntimeException'));
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::has()
     */
    public function testHas()
    {
        $this->assertTrue($this->registry->has('a'));
        $this->assertTrue($this->registry->has('b'));
        $this->assertFalse($this->registry->has('d'));
        $this->assertFalse($this->registry->has('123'));
    }

    /**
     * @covers \HalimonAlexander\Registry\Registry::set()
     */
    public function testSet()
    {
        $this->assertFalse($this->registry->has("abcd"));
        $this->assertNull($this->registry->get("abcd"));

        $this->registry->set('abcd', 1234);

        $this->assertTrue($this->registry->has('abcd'));
        $this->assertEquals(1234, $this->registry->get('abcd'));
    }
}
