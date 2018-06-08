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

class Registry implements IRegistry
{
    /**
     * @var IRegistry
     */
    private static $instance;

    /**
     * @var array Data container
     */
    private $container = [];

    /**
     * @inheritdoc
     */
    public static function getInstance(): IRegistry
    {
        return self::$instance ?? self::$instance = new self();
    }

    /**
     * @inheritdoc
     */
    public function get(string $key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }

        return $this->container[$key];
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, $value): IRegistry
    {
        $this->container[$key] = $value;

        return $this;
    }
}
