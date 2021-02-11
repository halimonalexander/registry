<?php

namespace HalimonAlexander\Tests\Registry;

use HalimonAlexander\Registry\RegistryInterface;
use HalimonAlexander\Registry\Registry;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \HalimonAlexander\Registry\Registry
 */
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

    public function tearDown()
    {
        $this->registry->setContainer([]);
    }

    public function testRestrictDirectCreate()
    {
        $this->expectException(\Throwable::class);

        $registry = new Registry();
    }

    /**
     * @covers ::getInstance
     */
    public function testInstance(): void
    {
        $this->assertInstanceOf(RegistryInterface::class, Registry::getInstance());
    }

    /**
     * @covers ::get
     */
    public function testGetEmptyKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->get('');
    }

    /**
     * @covers ::get
     */
    public function testGet(): void
    {
        $this->assertEquals(1, $this->registry->get('a'));
        $this->assertEquals(["1" => "a"], $this->registry->get('c'));

        // test default value
        $this->assertEquals('abc', $this->registry->get('na-key', 'abc'));
    }

    /**
     * @covers ::getByClassname
     * @covers ::isValidClassname
     */
    public function testGetByClassnameInvalidKey():void
    {
        $this->registry->set('some-key', new \RuntimeException());

        $this->expectException(\InvalidArgumentException::class);
        $this->registry->getByClassname('not-a-class-name');
    }

    /**
     * @covers ::getByClassname
     */
    public function testGetByClassnameNoObject(): void
    {
        $this->assertNull(
            $this->registry->getByClassname(\RuntimeException::class)
        );
    }

    /**
     * @covers ::getByClassname
     */
    public function testGetByClassnameStrict(): void
    {
        $this->registry->set('exception', new \RuntimeException());

        $this->assertInstanceOf(
            \RuntimeException::class,
            $this->registry->getByClassname(\RuntimeException::class, true)
        );
    }

    /**
     * @covers ::getByClassname
     */
    public function testGetByClassnameContract(): void
    {
        $this->registry->set('exception', new \RuntimeException());

        $this->assertInstanceOf(
            \RuntimeException::class,
            $this->registry->getByClassname(\Throwable::class, false)
        );
    }

    /**
     * @covers ::has
     */
    public function testHasEmptyKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->has('');
    }

    /**
     * @covers ::has
     */
    public function testHas(): void
    {
        $this->assertTrue($this->registry->has('a'));
        $this->assertTrue($this->registry->has('b'));
        $this->assertFalse($this->registry->has('d'));
        $this->assertFalse($this->registry->has('123'));
    }

    /**
     * @covers ::set
     */
    public function testSetEmptyKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->registry->set('', 123);
    }

    /**
     * @covers ::set
     */
    public function testSet(): void
    {
        $this->registry->set('abcd', 1234);

        $this->assertTrue($this->registry->has('abcd'));
        $this->assertEquals(1234, $this->registry->get('abcd'));
    }

    /**
     * @covers ::setContainer
     */
    public function testSetContainer(): void
    {
        $this->registry->setContainer([
            "aa" => 1,
            "bb" => 2,
        ]);

        $this->assertFalse($this->registry->has('a'));
        $this->assertTrue($this->registry->has('aa'));
        $this->assertEquals(1, $this->registry->get('aa'));
    }
}
