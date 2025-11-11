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

use Inane\Stdlib\Options;

use function file_exists;
use function glob;
use function is_string;

use const GLOB_BRACE;
use const GLOB_NOSORT;
use const false;
use const true;

/**
 * Class Config
 *
 * Extends the Options class to provide configuration management functionality.
 * This class is responsible for handling application configuration options.
 * 
 * configuration keys:
 * - `glob_pattern`: A pattern to match configuration files.
 * - `allow_modifications`: A boolean indicating whether the configuration can be modified after creation.
 *
 * @version 0.3.0
 */
class Config extends Options {
    /**
     * Creates a new instance of the class from a configuration file.
     *
     * @param string      $file      The path to the configuration file. Defaults to 'config/app.config.php'.
     * @param null|string $configKey The key to use when retrieving configuration data. Defaults to 'config'.
     * 
     * @return static An instance of the class initialized with the configuration data.
     */
    public static function fromConfigFile(string $file = 'config/app.config.php', ?string $configKey = 'config'): static {
        if (file_exists($file)) {
            $config = new static(include $file, true);
            if (!empty($configKey)) {
                if ($config->offsetExists($configKey)) {
                    $cfg = $config->get($configKey);
                    $cfg->complete([
                        'glob_pattern' => 'config/autoload/{{,*.}global,{,*.}local}.php',
                        'allow_modifications' => false,
                    ]);

                    if (is_string($cfg->glob_pattern) && !empty($cfg->glob_pattern)) {
                        $files = glob($cfg->glob_pattern, GLOB_BRACE | GLOB_NOSORT);
                        foreach ($files as $file) $config->merge(include $file);
                    }

                    if (!$cfg->allow_modifications) $config->lock();
                }
            }
        } else $config = new static([], true);

        return $config;
    }

	/**
	 * Retrieves the configuration for the specified class.
	 *
	 * @since 0.3.0
	 *
	 * @param string $class The class name for which the configuration is being retrieved.
	 *
	 * @return static|null The configuration instance if it exists, or null otherwise.
	 */
	public function getConfig(string $class): ?static {
        return $this->get($class);
    }
}
