<?php

declare(strict_types=1);

return [
    'config' => [
        // Point the glob to this fixture directory's autoload files
        'glob_pattern' => __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
        'allow_modifications' => false,
    ],
];
