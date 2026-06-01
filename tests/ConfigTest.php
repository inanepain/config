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

namespace Inane\Config\Tests;

use Inane\Config\Config;
use Inane\Stdlib\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

/**
 * Helper class used as a key for component-specific configuration in fixtures.
 */
class Dummy {}

/**
 * Tests for `Inane\\Config\\Config` behaviour when loading configuration files.
 *
 * Verifies default locking behaviour, mutability flag, and retrieval of
 * component-specific subsets via `getConfig()`.
 */
final class ConfigTest extends TestCase {
    /**
     * Builds an absolute path to a file inside this test's `fixtures` directory.
     *
     * @param string $path Relative path within the fixtures directory
     *
     * @return string Absolute filesystem path to the requested fixture
     */
    private static function fixture(string $path): string {
        // Normalise provided path and append to local fixtures directory
        return __DIR__ . '/fixtures/' . ltrim($path, '/');
    }

    /**
     * Ensures that loading from the default `app.config.php` results in a
     * merged configuration that is locked (immutable) by default and contains
     * values from both global and local autoload files.
     *
     * @return void
     */
    public function testFromConfigFileMergesAndLocksByDefault(): void {
        $file = self::fixture('app.config.php');
        $config = Config::fromConfigFile($file);

        // From autoload/test.global.php
        self::assertSame('bar', $config->get('foo'));
        // From autoload/test.local.php
        self::assertSame(5, $config->get('baz'));

        // By default, allow_modifications = false, so it should be locked
        self::assertTrue($config->isLocked());
    }

    /**
     * Verifies that when `allow_modifications` is true in the config file, the
     * resulting `Config` instance remains mutable and allows setting new values.
     *
     * @return void
     * @throws RuntimeException
     */
    public function testAllowModificationsTrueLeavesConfigMutable(): void {
        $file = self::fixture('app.mutable.config.php');
        $config = Config::fromConfigFile($file);

        self::assertFalse($config->isLocked());

        // Should be able to modify when not locked
        $config->set('dynamic', 'yes');
        self::assertSame('yes', $config->get('dynamic'));
    }

    /**
     * Asserts that `getConfig()` returns a subset for known component keys and
     * `null` for unknown/non-configured component identifiers.
     *
     * @return void
     */
    public function testGetConfigReturnsSubsetOrNull(): void {
        $file = self::fixture('app.config.php');
        $config = Config::fromConfigFile($file);

        $subset = $config->getConfig(Dummy::class);
        self::assertNotNull($subset);
        self::assertSame(42, $subset->get('answer'));

        self::assertNull($config->getConfig(__CLASS__ . '\\NotConfigured'));
    }
}
