<?php

namespace Growset2\Tests;

use Growset2\Service\ProductProvider;
use Growset2\Tests\Stubs\AttributeGroup as AttributeGroupStub;
use Growset2\Tests\Stubs\Feature as FeatureStub;
use Growset2\Tests\Stubs\Product as ProductStub;
use PHPUnit\Framework\TestCase;

class ProductProviderTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists('Product', false)) {
            class_alias(ProductStub::class, 'Product');
        }
        if (!class_exists('Feature', false)) {
            class_alias(FeatureStub::class, 'Feature');
        }
        if (!class_exists('AttributeGroup', false)) {
            class_alias(AttributeGroupStub::class, 'AttributeGroup');
        }
    }

    public function testGetProducts()
    {
        $provider = new ProductProvider();
        $products = $provider->getProducts(1, 1);
        $this->assertSame([['id_product' => 1]], $products);
    }

    public function testGetFilters()
    {
        $provider = new ProductProvider();
        $filters = $provider->getFilters(1, 1);
        $this->assertArrayHasKey('features', $filters);
        $this->assertArrayHasKey('attributes', $filters);
        $this->assertCount(1, $filters['features']);
        $this->assertCount(1, $filters['attributes']);
    }
}

namespace Growset2\Tests\Stubs;

class Product
{
    public static function getProducts($idLang, $start, $limit, $orderBy, $orderWay)
    {
        return [['id_product' => 1]];
    }
}

class Feature
{
    public static function getFeatures($idLang)
    {
        return [['id_feature' => 1], ['id_feature' => 2]];
    }
}

class AttributeGroup
{
    public static function getAttributesGroups($idLang)
    {
        return [['id_attribute_group' => 1], ['id_attribute_group' => 2]];
    }
}
