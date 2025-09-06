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
        return [
            ['id_feature' => 1, 'name' => 'Feature 1'],
            ['id_feature' => 2, 'name' => 'Feature 2'],
        ];
    }
}

class AttributeGroup
{
    public static function getAttributesGroups($idLang)
    {
        return [
            ['id_attribute_group' => 1, 'name' => 'Attribute 1'],
            ['id_attribute_group' => 2, 'name' => 'Attribute 2'],
        ];
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
        $filters = $provider->getFilters('features', 1, 1);
        $this->assertSame(1, $filters['page']);
        $this->assertSame(2, $filters['totalPages']);
        $this->assertCount(1, $filters['items']);
        $this->assertSame([
            ['value' => '1', 'label' => 'Feature 1'],
        ], $filters['items']);

        $attrFilters = $provider->getFilters('attributes', 1, 1);
        $this->assertSame([
            ['value' => '1', 'label' => 'Attribute 1'],
        ], $attrFilters['items']);
    }
}
