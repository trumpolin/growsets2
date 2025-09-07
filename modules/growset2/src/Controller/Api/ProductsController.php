<?php

namespace Growset2\Controller\Api;

use Cache;
use Growset2\Service\ProductProvider;
use ModuleFrontController;
use Growset2\Controller\Api\JsonResponseTrait;
use Growset2\Controller\Api\PaginationValidatorTrait;

class ProductsController extends ModuleFrontController
{
    use JsonResponseTrait;
    use PaginationValidatorTrait;

    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        list($page, $limit) = $this->validatePagination();
        $cacheKey = sprintf('growset2_products_%d_%d', $page, $limit);
        $ttl = 300;

        $this->jsonResponse($cacheKey, $ttl, function () use ($page, $limit) {
            $client = new ProductProvider();
            $data = $client->getProducts($page, $limit);
            return [
                'page' => $page,
                'limit' => $limit,
                'data' => $data,
            ];
        });
    }
}

