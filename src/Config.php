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

use Inane\Stdlib\ArrayUtil;
use Inane\Stdlib\Options;

use function glob;

use const false;
use const GLOB_NOSORT;
use const GLOB_BRACE;

class Config extends Options {
    /**
     * Create config
     * 
     * @param array|\Inane\Stdlib\Options $config options
     * @param bool $allowModifications allow config modifications.
     * 
     * @return static Configuration options
     */
    public static function withArray(array|Options $config, bool $allowModifications = false): static {
        return new self($config, $allowModifications);
    }

    /**
     * Create config
     * 
     * @param string $glob_pattern file pattern to use to find config files.
     * @param bool $allowModifications allow config to be modified.
     * 
     * @return static Configuration options
     */
    public static function factory(string $glob_pattern = 'config/autoload/{{,*.}global,{,*.}local}.php', bool $allowModifications = false): static {
        $config = new self([], true);
        $config->mergeGlob($glob_pattern);

        if (!$allowModifications) $config->lock();

        return $config;
    }
    
    /**
     * Create config using options from config file.
     * 
     * Required fields:
     * - string - ['config']['glob_pattern']
     * - bool - ['config']['allowModifications']
     * 
     * @param string $configFile file to config building of config
     * 
     * @return static Configuration options
     */
    public function mergeGlob(string $glob_pattern = 'config/autoload/{{,*.}global,{,*.}local}.php'): self {
        $files = glob($glob_pattern, GLOB_BRACE | GLOB_NOSORT);
        foreach ($files as $file) $this->merge(include $file);

        return $this;
    }
}
