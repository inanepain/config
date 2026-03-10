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
 * @author   Philip Michael Raab<philip@cathedral.co.za>
 * @package  inanepain\config
 * @category config
 *
 * @license  UNLICENSE
 * @license  https://unlicense.org/UNLICENSE UNLICENSE
 *
 * _version_ $version
 */

declare(strict_types = 1);

namespace Inane\Config\ConfigAware;

use Attribute;
use Inane\Stdlib\Exception\InvalidArgumentException;

use function preg_match;

/**
 * ConfigAwareAttribute
 *
 * // TODO: validate configKey
 * @version 0.3.0
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class ConfigAwareAttribute {
    /**
     * Defines the regular expression pattern for validating configuration keys.
     *
     * @since 0.3.0
     *
     * The string must be a *valid* regular *expression pattern* or *null* to *disable validation*.
     *
     * The default pattern allows for:
     *   - Integers (both positive and negative).
     *   - Valid PHP variable names.
     *   - Fully qualified class names using namespaces.
     *
     * The regex ensures the configuration key adheres to valid naming conventions.
     */
    public static ?string $configKeyPattern = '/^(?:-?\d+|[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*(?:\\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)*)$/';

    /**
     * Constructor for the attribute class.
     *
     * The parameters allow for customising the attribute's behavior.
     *
     * The `$globalConfig` parameter is deprecated and will be removed in version *0.4.0*.
     * If both `$globalConfig` & `$configKey` are provided, `$configKey` takes precedence.
     *
     * @since 0.3.0 - `$configKey` replaces/deprecates `$globalConfig` which will be removed in *0.4.0*.
     *
     * @param bool|string $configKey    Customise the configuration that the class requires:
     *                                  - false - no custom key = the global configuration is used.
     *                                  - true - the class is used as the custom key.
     *                                  - string - use the provided string as the custom key.
     * @param bool        $globalConfig Whether the class uses the global or a custom configuration.
     *                                  - true - global configuration.
     *                                  - false - custom class-specific configuration.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(
        /**
         * Customise the configuration that the class requires:
         *   - false - no custom key = the global configuration is used.
         *   - true - the class is used as the custom key.
         *   - string - use the provided string as the custom key.
         *
         * @since 0.3.0
         */ public bool|string $configKey = true, /**
     * Whether the class uses the global or a custom configuration.
     *   - true - global configuration.
     *   - false - custom class-specific configuration.
     *
     * @deprecated Use $configKey instead.
     */ public bool            $globalConfig = false,
    ) {
        // TODO: validate configKey
        $this->validateConfigKey($this->configKey);
    }

    /**
     * Validates whether the provided configuration key adheres to the allowed format.
     *
     * The key must conform to specific naming conventions:
     * - It may represent an integer (positive or negative).
     * - It may be a valid string identifier beginning with an alphabetic character or underscore,
     *   followed by alphanumeric characters, underscores, or valid multibyte characters.
     * - Namespaces are supported, where segments are separated by backslashes.
     *
     * @param bool|string $key The configuration key to be validated.
     *
     * @return bool Returns true if the key is valid, otherwise false.
     */
    protected function isValidConfigKey(bool|string $key): bool {
        if (is_bool($key)) return true;
        return !self::$configKeyPattern || (bool)preg_match(self::$configKeyPattern, $key);
    }

    /**
     * Validates the provided configuration key.
     *
     * This method checks if the given configuration key is valid.
     * If the key is invalid, an exception is thrown.
     *
     * @param bool|string $key The configuration key to be validated.
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if the provided key is not a valid configuration key.
     */
    protected function validateConfigKey(bool|string $key): void {
        if (!$this->isValidConfigKey($key)) {
            throw new InvalidArgumentException("Invalid configuration key: $key");
        }
    }

    /**
     * Retrieves the configuration key based on the current state of the configKey property.
     *
     * @param class-string $class The fully qualified name of the class, used when the configKey is set to true.
     *
     * @return false|string Returns false if configKey is set to false, the passed class name if configKey is true,
     *                      or the value of configKey if it holds a string.
     */
    public function getConfigKey(string $class): false|string {
        return match ($this->configKey) {
            false => false,
            true => $class,
            default => $this->configKey
        };
    }
}
