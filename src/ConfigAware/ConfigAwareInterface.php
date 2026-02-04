<?php

/**
 * Inane: Config
 *
 * Configuration helpers.
 *
 * $Id$
 * $Date$
 *
 * PHP version 8.5
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

use Inane\Stdlib\Array\OptionsInterface;

/**
 * ConfigAwareInterface
 *
 * @version 0.1.0
 */
interface ConfigAwareInterface {
	/**
	 * configuration
	 *
	 * @param array|OptionsInterface $config configuration
	 *
	 * @return void
	 */
	public function setConfig(array|OptionsInterface $config): void;
}
