<?php

/**
 * Inane: Config
 *
 * Configuration helpers.
 *
 * $Id$
 * $Date$
 *
 * PHP version 8.4
 *
 * @author Philip Michael Raab<philip@cathedral.co.za>
 * @package inanepain\config
 * @category config
 *
 * @license UNLICENSE
 * @license https://unlicense.org/UNLICENSE UNLICENSE
 *
 * _version_ $version
 */

declare(strict_types=1);

namespace Inane\Config\ConfigAware;

use Inane\Config\Config;
use Inane\Stdlib\Array\OptionsInterface;
use Inane\Stdlib\Options;
use function is_array;
use function property_exists;

/**
 * ConfigAwareTrait
 *
 * @version 0.4.0
 */
trait ConfigAwareTrait {
    /**
     * Configuration
     *
     * @var array|OptionsInterface
     */
    protected array|OptionsInterface $config;

    /**
     * {@inheritDoc}
     * @see \Inane\Config\ConfigAware\ConfigAwareInterface::setConfig()
     *
     * @since 0.4.0 Looks for defaultConfig property to use as fallback and default values.
     */
    public function setConfig(array|OptionsInterface $config): void {
        $class = Config::class;
        if (!is_array($config) && $config instanceof Options) $class = Options::class;

        if (!isset($this->config)) $this->config = new $class([]);
        if (!$this->config->isLocked()) {
            $this->config = new $class(property_exists($this, 'defaultConfig') ? $this->defaultConfig : [])->merge($config);
            $this->config->lock();
        }
    }
}
