<?php

namespace Growset2\Controller\Api;

use Cache;
use Growset2\Service\ProductProvider;
use ModuleFrontController;
use Tools;
use Growset2\Controller\Api\JsonResponseTrait;

class ProductsController extends ModuleFrontController
{
    use JsonResponseTrait;

    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $page = (int) Tools::getValue('page', 1);
        $limit = (int) Tools::getValue('limit', 20);
        if ($page < 1 || $limit < 1 || $limit > 100) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Invalid page or limit']);
            exit;
        }
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

