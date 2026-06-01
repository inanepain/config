<?php

declare(strict_types=1);

use Inane\Config\Tests\Dummy;

return [
    'foo' => 'bar',
    'components' => [
        Dummy::class => [
            'answer' => 42,
        ],
    ],
];
