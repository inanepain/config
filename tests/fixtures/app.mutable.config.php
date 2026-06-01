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
        // Use the same autoload fixtures but allow modifications
        'glob_pattern'        => __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
        'allow_modifications' => true,
    ],
];
