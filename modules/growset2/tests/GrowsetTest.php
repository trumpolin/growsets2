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

use Growset2\Growset2;
use PHPUnit\Framework\TestCase;

class GrowsetTest extends TestCase
{
    protected function setUp(): void
    {
        Cache::$keys = [];
    }

    public function testAddHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductAdd([]);

        $this->assertSame(['growset2_products'], Cache::$keys);
    }

    public function testUpdateHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductUpdate([]);

        $this->assertSame(['growset2_products'], Cache::$keys);
    }

    public function testDeleteHookClearsCache(): void
    {
        $module = new Growset2();
        $module->hookActionProductDelete([]);

        $this->assertSame(['growset2_products'], Cache::$keys);
    }
}
