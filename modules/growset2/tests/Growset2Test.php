<?php

namespace Growset2\Tests;

use Growset2\Growset2;
use Growset2\Tests\Stubs\Cache as CacheStub;
use Growset2\Tests\Stubs\Module as ModuleStub;
use PHPUnit\Framework\TestCase;

class Growset2Test extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists('Module', false)) {
            class_alias(ModuleStub::class, 'Module');
        }
        if (!class_exists('Cache', false)) {
            class_alias(CacheStub::class, 'Cache');
        }
        CacheStub::$keys = [];
    }

    public function testAddHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductAdd([]);

        $this->assertSame(['growset2_products'], CacheStub::$keys);
    }

    public function testUpdateHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductUpdate([]);

        $this->assertSame(['growset2_products'], CacheStub::$keys);
    }

    public function testDeleteHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductDelete([]);

        $this->assertSame(['growset2_products'], CacheStub::$keys);
    }
}

namespace Growset2\Tests\Stubs;

class Module
{
    public function __construct()
    {
    }

    protected function l(string $str): string
    {
        return $str;
    }
}

class Cache
{
    public static array $keys = [];

    public static function clean(string $key): void
    {
        self::$keys[] = $key;
    }
}
