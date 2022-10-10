<?php

/**
 * Inane: Config
 *
 * Inane Standard Library
 *
 * PHP version 8.1
 *
 * @author Philip Michael Raab<peep@inane.co.za>
 * @package Inane\Config
 *
 * @license UNLICENSE
 * @license https://github.com/inanepain/stdlib/raw/develop/UNLICENSE UNLICENSE
 *
 * @version $Id$
 * $Date$
 */

declare(strict_types=1);

namespace Inane\Config;

use Laminas\Config\Config;

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
	 * @var array|\Inane\Config\Options|\Laminas\Config\Config
	 */
	protected array|\Inane\Stdlib\Options|Config $config;

	/**
	 * {@inheritDoc}
	 * @see \Inane\Config\ConfigAwareInterface::setConfig()
	 */
	public function setConfig(array|\Inane\Stdlib\Options|Config $config): void {
		if (is_array($config)) $this->config = new \Inane\Stdlib\Options($config);
		else $this->config = $config;
	}
}
