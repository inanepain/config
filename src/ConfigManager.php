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

namespace Inane\Config;

use Inane\Config\ConfigAware\ConfigAwareAttribute;
use Inane\Config\Exception\ConfigNotFoundException;
use ReflectionObject;

final class ConfigManager {
    /**
     * The singleton instance of the Config Manager.
     */
    private static ConfigManager $instance;

    /**
     * The configuration settings for the application.
     */
    private ConfigInterface $config;

    /**
     * Config Manager constructor.
     *
     * @return void
     */
    private function __construct() {}

    /**
     * Returns the singleton instance of the Config Manager.
     *
     * @return static The instance of the Config Manager.
     */
    public static function instance(): self {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        /**
         * @var static Instance of ConfigManager
         */
        return self::$instance;
    }

    /**
     * Sets the configuration for the provided object based on its attributes.
     *
     * The method initializes the configuration if it has not been set already.
     * Then, it inspects the attributes of the provided object using reflection.
     * If attributes implementing the ConfigAwareAttribute class are found, their
     * configuration keys are used to retrieve specific configurations and apply them
     * to the object. If no specific key is defined, the default configuration is applied.
     *
     * @param object|null $object  The object for which the configuration is being set.
     *                             If null, no operation is performed on any object,
     *                             though the configuration may still be initialized.
     *
     * @return ConfigInterface The configuration instance that is applied to the object.
     */
    public function setConfigFor(?object $object = null): ConfigInterface {
        if (!isset($this->config)) $this->setConfig();

        $reflection = new ReflectionObject($object);

        foreach($reflection->getAttributes(ConfigAwareAttribute::class) as $configAttribute) {
            $attribute = $configAttribute->newInstance();
            $object->setConfig($this->getConfig($attribute->getConfigKey($object::class)));
        }

        return $this->config;
    }

    /**
     * Retrieves the configuration based on the provided key or the entire configuration object if no key is provided.
     *
     * @param false|string $key The key to retrieve specific configuration. If null, returns the entire configuration object.
     *
     * @return ConfigInterface The requested configuration or the entire configuration object.
     *
     * @throws ConfigNotFoundException Exception thrown when a requested configuration is not found.
     */
    public function getConfig(false|string $key = false): ConfigInterface {
        if (!isset($this->config)) $this->setConfig();
        if ($key === false) return $this->config;

        $config = $this->config->getConfig($key);
        if ($config === null) {
            throw new ConfigNotFoundException("Configuration for key '$key' not found.");
        }

        return $config;
    }

    /**
     * Sets the configuration for the current instance.
     *
     * @param ConfigInterface|null $config An optional configuration object. If null, a default configuration will be loaded from the configuration file.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setConfig(?ConfigInterface $config = null): self {
        $this->config = $config ?? Config::fromConfigFile();

        return $this;
    }
}
