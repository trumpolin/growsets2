<?php

namespace Growset\Service;

use Product;
use Feature;
use AttributeGroup;
use Configuration;

class ProductProvider
{
    public function getProducts(int $page, int $limit): array
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

        $start = max(0, ($page - 1) * $limit);
        return Product::getProducts($idLang, $start, $limit, 'id_product', 'ASC');
    }

    public function getFilters(int $page, int $limit): array
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
}
