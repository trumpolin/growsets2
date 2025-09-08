<?php

namespace Growset2\Service;

use Product;
use Feature;
use AttributeGroup;
use Configuration;
use Growset2\Growset2;

class ProductProvider
{
    public function getProducts(int $page, int $limit): array
    {
        $idLang = $this->getLanguageId();

        $keys = [
            Growset2::CONFIG_GROWBOX_CATEGORY,
            Growset2::CONFIG_GROWLED_CATEGORY,
            Growset2::CONFIG_ABLUFT_VENTILATOR_CATEGORY,
            Growset2::CONFIG_AKTIVKOHLEFILTER_CATEGORY,
            Growset2::CONFIG_ABLUFTSCHLAUCH_CATEGORY,
            Growset2::CONFIG_UMLUFTVENTILATOR_CATEGORY,
            Growset2::CONFIG_CONTROLLER_CATEGORY,
        ];

        $categoryIds = [];
        foreach ($keys as $key) {
            $id = 0;
            if (class_exists('Configuration')) {
                $id = (int) Configuration::get($key);
            }
            if ($id <= 0) {
                $id = (int) getenv($key);
            }
            if ($id > 0) {
                $categoryIds[] = $id;
            }
        }
        $categoryIds = array_values(array_unique($categoryIds));

        if (empty($categoryIds)) {
            $rawIds = '';
            if (class_exists('Configuration')) {
                $rawIds = (string) Configuration::get('GROWSET2_CATEGORY_IDS');
            }
            if ($rawIds === '') {
                $rawIds = (string) getenv('GROWSET2_CATEGORY_IDS');
            }
            if ($rawIds !== '') {
                $categoryIds = array_values(array_filter(array_map('intval', preg_split('/\s*,\s*/', $rawIds, -1, PREG_SPLIT_NO_EMPTY))));
            }
        }

        if (empty($categoryIds)) {
            $start = max(0, ($page - 1) * $limit);
            return Product::getProducts($idLang, $start, $limit, 'id_product', 'ASC');
        }

        $products = Product::getProducts($idLang, 0, 0, 'id_product', 'ASC');
        $products = array_values(array_filter($products, function (array $product) use ($categoryIds) {
            $categories = Product::getProductCategories((int) $product['id_product']);
            return (bool) array_intersect($categoryIds, $categories);
        }));

        $start = max(0, ($page - 1) * $limit);
        return array_slice($products, $start, $limit);
    }

    public function getCategoryArticles(int $categoryId, int $page, int $limit, ?int $relatedId = null): array
    {
        $idLang = $this->getLanguageId();

        $products = Product::getProducts($idLang, 0, 0, 'id_product', 'ASC');
        $products = array_values(array_filter($products, function (array $product) use ($categoryId, $relatedId) {
            if ($relatedId !== null && (int) $product['id_product'] === $relatedId) {
                return false;
            }
            $categories = Product::getProductCategories((int) $product['id_product']);
            return in_array($categoryId, $categories);
        }));

        $total = count($products);
        $start = max(0, ($page - 1) * $limit);
        $slice = array_slice($products, $start, $limit);

        $items = array_map(function (array $product) {
            return [
                'id' => (string) $product['id_product'],
                'title' => $product['name'] ?? '',
                'description' => $product['description_short'] ?? '',
                'image' => $product['image'] ?? null,
                'price' => isset($product['price']) ? (float) $product['price'] : null,
            ];
        }, $slice);

        return [
            'items' => $items,
            'page' => $page,
            'totalPages' => $limit > 0 ? (int) ceil($total / $limit) : 0,
        ];
    }

    public function getFilters(int $page, int $limit): array
    {
        $idLang = $this->getLanguageId();

        $features = Feature::getFeatures($idLang);
        $attributes = AttributeGroup::getAttributesGroups($idLang);

        $offset = max(0, ($page - 1) * $limit);
        $features = array_slice($features, $offset, $limit);
        $attributes = array_slice($attributes, $offset, $limit);

        return [
            'features' => $features,
            'attributes' => $attributes,
        ];
    }

    private function getLanguageId(): int
    {
        $idLang = 1;
        if (class_exists('Context')) {
            $ctx = \Context::getContext();
            if (isset($ctx->language) && isset($ctx->language->id)) {
                $idLang = (int) $ctx->language->id;
            }
        } elseif (class_exists('Configuration')) {
            $idLang = (int) Configuration::get('PS_LANG_DEFAULT', 1);
        }

        return $idLang;
    }
}
