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

namespace Inane\Config;

use Attribute;

/**
 * ConfigAwareAttribute
 *
 * @version 0.2.0
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class ConfigAwareAttribute {
    /**
     * Constructor for the class.
     *
     * @param bool $globalConfig Whether to use global configuration.
     *                           - false - looks for class-specific configuration
     *                           - true - uses global configuration
     *
     * @return void
     */
    public function __construct(
        /**
         * Whether to use global configuration.
         * - false - looks for class-specific configuration
         * - true - uses global configuration
         */
        public bool $globalConfig = false,
    ) {

    }
}
