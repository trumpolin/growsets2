<?php

use Growset\Service\ProductProvider;
use PHPUnit\Framework\TestCase;

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

class ProductProviderTest extends TestCase
{
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
