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

    public function getFilters(string $facet, int $page, int $limit): array
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

        switch ($facet) {
            case 'attributes':
                $raw = AttributeGroup::getAttributesGroups($idLang);
                $valueKey = 'id_attribute_group';
                $labelKey = 'name';
                break;
            case 'features':
            default:
                $raw = Feature::getFeatures($idLang);
                $valueKey = 'id_feature';
                $labelKey = 'name';
                break;
        }

        $totalPages = (int) ceil(count($raw) / $limit);
        $offset = max(0, ($page - 1) * $limit);
        $raw = array_slice($raw, $offset, $limit);

        $items = array_map(function ($row) use ($valueKey, $labelKey) {
            return [
                'value' => (string) $row[$valueKey],
                'label' => $row[$labelKey],
            ];
        }, $raw);

        return [
            'items' => $items,
            'page' => $page,
            'totalPages' => $totalPages,
        ];
    }
}
