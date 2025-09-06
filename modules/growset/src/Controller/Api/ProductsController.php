<?php

namespace Growset\Controller\Api;

use Cache;
use Growset\Service\BackendClient;
use ModuleFrontController;
use Tools;

class ProductsController extends ModuleFrontController
{
    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $page = (int) Tools::getValue('page', 1);
        $limit = (int) Tools::getValue('limit', 20);
        $cacheKey = sprintf('growset_products_%d_%d', $page, $limit);
        $ttl = 300;

        $content = Cache::retrieve($cacheKey);
        if (!$content) {
            $client = new BackendClient();
            $data = $client->getProducts($page, $limit);
            $content = json_encode([
                'page' => $page,
                'limit' => $limit,
                'data' => $data,
            ]);
            Cache::store($cacheKey, $content, $ttl);
        }

        $etag = md5($content);
        header('Content-Type: application/json');
        header('Cache-Control: max-age=' . $ttl);
        header('ETag: ' . $etag);

        if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        echo $content;
        exit;
    }
}

