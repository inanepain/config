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
 * @version $version
 */

declare(strict_types=1);

namespace Inane\Config;

use Inane\Stdlib\Array\OptionsInterface;

use function is_array;

/**
 * ConfigAwareTrait
 *
 * @package Inane\Config
 *
 * @version 0.1.0
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
	 * @see \Inane\Config\ConfigAwareInterface::setConfig()
	 */
	public function setConfig(array|OptionsInterface $config): void {
		if (is_array($config)) $this->config = new \Inane\Config\Config($config);
		else $this->config = $config;
	}
}
