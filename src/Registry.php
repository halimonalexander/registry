<?php
/*
 * This file is part of Registry.
 *
 * (c) Halimon Alexander <vvthanatos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace HalimonAlexander\Registry;

use InvalidArgumentException;

/**
 * Class Registry
 *
 * @package HalimonAlexander\Registry
 */
class Registry implements RegistryInterface
{
    /**
     * @var Registry Class instance
     */
    private static $instance;

    /**
     * @var array Data container
     */
    private $container = [];

    final private function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    final public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * @inheritdoc
     */
    final public function get(string $key, $default = null)
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key argument cannot be empty');
        }

        if (!$this->has($key)) {
            return $default;
        }

        return $this->container[$key];
    }

    /**
     * Get registered value by class name. If not found, will return null.
     *
     * @param string $classname
     *
     * @return mixed|null
     */
    final public function getByClassname(string $classname)
    {
        foreach ($this->container as $value) {
            if (is_object($value) && $value instanceof $classname) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    final public function has(string $key): bool
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key argument cannot be empty');
        }

        return array_key_exists($key, $this->container);
    }

    /**
     * @inheritdoc
     */
    final public function set(string $key, $value): RegistryInterface
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key argument cannot be empty');
        }

        $this->container[$key] = $value;

        return $this;
    }
    
    /**
     * Sets the entire container.
     *
     * @param array $container
     *
     * @return void
     */
    final public function setContainer(array $container): void
    {
        $this->container = $container;
    }
}
