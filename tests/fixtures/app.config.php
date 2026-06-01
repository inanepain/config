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

return [
    'config' => [
        // Point the glob to this fixture directory's autoload files
        'glob_pattern'        => __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
        'allow_modifications' => false,
    ],
];
