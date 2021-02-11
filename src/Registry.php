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
        return self::$instance ?? self::$instance = new static();
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
     * @inheritdoc
     */
    final public function getByClassname(string $classname, bool $strict = true)
    {
        if (!$this->isValidClassname($classname, $strict)) {
            throw new InvalidArgumentException(
                sprintf('Provided classname `%s` is a not valid class', $classname)
            );
        }

        foreach ($this->container as $value) {
            if (is_object($value) && get_class($value) === $classname) {
                return $value;
            }
        }

        if (!$strict) {
            foreach ($this->container as $value) {
                if (is_object($value) && $value instanceof $classname) {
                    return $value;
                }
            }
        }

        return null;
    }

    private function isValidClassname(string $classname, bool $strict): bool
    {
        if ($strict && class_exists($classname)) {
            return true;
        } elseif (!$strict && (class_exists($classname) || interface_exists($classname))) {
            return true;
        } else {
            return false;
        }
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
     * @inheritdoc
     */
    final public function setContainer(array $container): void
    {
        $this->container = $container;
    }
}
