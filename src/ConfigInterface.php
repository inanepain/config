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

namespace Inane\Config;

use Inane\Stdlib\Array\OptionsInterface;

/**
 * ConfigInterface
 *
 * @version 0.1.0
 */
interface ConfigInterface extends OptionsInterface {
	/**
	 * get configuration for class
	 *
	 * @param class-string $class class string.
	 *
	 * @return null|static configuration or null if not found.
	 */
	public function getConfig(string $class): ?static;
}
