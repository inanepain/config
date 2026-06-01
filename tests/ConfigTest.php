<?php

declare(strict_types=1);

namespace Inane\Config\Tests;

use Inane\Config\Config;
use PHPUnit\Framework\TestCase;

/**
 * Helper class used as a key for component-specific configuration in fixtures.
 */
class Dummy {}

final class ConfigTest extends TestCase {
    private static function fixture(string $path): string {
        return __DIR__ . '/fixtures/' . ltrim($path, '/');
    }

    public function testFromConfigFileMergesAndLocksByDefault(): void {
        $file = self::fixture('app.config.php');
        $config = Config::fromConfigFile($file);

        // From autoload/test.global.php
        self::assertSame('bar', $config->get('foo'));
        // From autoload/test.local.php
        self::assertSame(5, $config->get('baz'));

        // By default allow_modifications = false, so it should be locked
        self::assertTrue($config->isLocked());
    }

    public function testAllowModificationsTrueLeavesConfigMutable(): void {
        $file = self::fixture('app.mutable.config.php');
        $config = Config::fromConfigFile($file);

        self::assertFalse($config->isLocked());

        // Should be able to modify when not locked
        $config->set('dynamic', 'yes');
        self::assertSame('yes', $config->get('dynamic'));
    }

    public function testGetConfigReturnsSubsetOrNull(): void {
        $file = self::fixture('app.config.php');
        $config = Config::fromConfigFile($file);

        $subset = $config->getConfig(Dummy::class);
        self::assertNotNull($subset);
        self::assertSame(42, $subset->get('answer'));

        self::assertNull($config->getConfig(__CLASS__ . '\\NotConfigured'));
    }
}
