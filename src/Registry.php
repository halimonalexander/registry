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
class Registry implements IRegistry
{
    /**
     * @var IRegistry Class instance
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
    public function has(string $key): bool
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key argument cannot be empty');
        }

        return array_key_exists($key, $this->container);
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, $value): IRegistry
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key argument cannot be empty');
        }

        $this->container[$key] = $value;

        return $this;
    }
}
