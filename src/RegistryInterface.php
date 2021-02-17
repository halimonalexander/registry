<?php

/**
 * This file is part of Registry.
 *
 * (c) Halimon Alexander <a@halimon.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace HalimonAlexander\Registry;

use InvalidArgumentException;

interface RegistryInterface
{
    /**
     * Get register instance
     *
     * @return RegistryInterface
     */
    public static function getInstance(): RegistryInterface;

    /**
     * Get the registered value. If it does not exists, provided default value will be returned.
     *
     * @param string $key
     * @param mixed|null $default
     *
     * @throws InvalidArgumentException
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null);

    /**
     * Get registered value by class name.
     * If strict is false, can search by parent or interface.
     * If not found, will return null.
     *
     * @param string $classname
     * @param bool $strict
     *
     * @return mixed|null
     *
     * @throws InvalidArgumentException
     */
    public function getByClassname(string $classname, bool $strict = true);

    /**
     * Check if value with provided key is already registered.
     *
     * @param string $key
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Set the new value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     *
     * @return RegistryInterface
     */
    public function set(string $key, $value): RegistryInterface;

    /**
     * Sets the entire container.
     *
     * @param array $container
     *
     * @return void
     */
    public function setContainer(array $container): void;
}
