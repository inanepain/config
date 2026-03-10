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

namespace Inane\Config\Exception;

use Inane\Stdlib\Exception\ConfigurationException;

/**
 * Exception thrown when a requested configuration is not found.
 *
 * This exception indicates that an attempt to retrieve or access
 * a specific configuration has failed because the configuration
 * does not exist or is unavailable.
 */
class ConfigNotFoundException extends ConfigurationException {
}
