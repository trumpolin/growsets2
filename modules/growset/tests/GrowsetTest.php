<?php

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

use Growset\Growset;
use PHPUnit\Framework\TestCase;

class GrowsetTest extends TestCase
{
    protected function setUp(): void
    {
        Cache::$keys = [];
    }

    public function testAddHookClearsCache(): void
    {
        $module = new Growset();
        $module->hookActionProductAdd([]);

        $this->assertSame(['growset_products'], Cache::$keys);
    }

    public function testUpdateHookClearsCache(): void
    {
        $module = new Growset();
        $module->hookActionProductUpdate([]);

        $this->assertSame(['growset_products'], Cache::$keys);
    }

    public function testDeleteHookClearsCache(): void
    {
        $module = new Growset();
        $module->hookActionProductDelete([]);

        $this->assertSame(['growset_products'], Cache::$keys);
    }
}
