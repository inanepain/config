<?php

declare(strict_types=1);

return [
    'config' => [
        // Use the same autoload fixtures but allow modifications
        'glob_pattern' => __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
        'allow_modifications' => true,
    ],
];
