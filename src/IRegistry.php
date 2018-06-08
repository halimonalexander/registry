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

interface IRegistry
{
    /**
     * Get register instance
     *
     * @return IRegistry
     */
    public static function getInstance(): IRegistry;

    /**
     * Get the registered value. If it does not exists, provided default value will be returned.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null);

    /**
     * Check if value with provided key is already registered.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;


    /**
     * Set the new value.
     *
     * @param string $key
     * @param $value
     *
     * @return IRegistry
     */
    public function set(string $key, $value): IRegistry;
}
