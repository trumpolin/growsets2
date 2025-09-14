<?php

namespace Growset2\Controller\Api;

use ModuleFrontController;
use Growset2\Controller\Api\JsonResponseTrait;
use Growset2\Controller\Api\PaginationValidatorTrait;
use Growset2\Service\ProductProvider;
use Growset2\Growset2;
use Configuration;
use Tools;

class CategoryArticlesController extends ModuleFrontController
{
    use JsonResponseTrait;
    use PaginationValidatorTrait;

    public $ssl = true;

    public function initContent()
    {
        parent::initContent();

        $categoryParam = Tools::getValue('category');
        $categoryId = $categoryParam !== null ? (int) $categoryParam : 0;

        if ($categoryId <= 0 && is_string($categoryParam)) {
            $slug = $categoryParam;
            $map = [
                'growbox' => Growset2::CONFIG_GROWBOX_CATEGORY,
                'led' => Growset2::CONFIG_GROWLED_CATEGORY,
                'exhaust-fan' => Growset2::CONFIG_ABLUFT_VENTILATOR_CATEGORY,
                'carbon-filter' => Growset2::CONFIG_AKTIVKOHLEFILTER_CATEGORY,
                'duct' => Growset2::CONFIG_ABLUFTSCHLAUCH_CATEGORY,
                'circulation-fan' => Growset2::CONFIG_UMLUFTVENTILATOR_CATEGORY,
                'controller' => Growset2::CONFIG_CONTROLLER_CATEGORY,
            ];
            if (isset($map[$slug])) {
                $configKey = $map[$slug];
                $categoryId = (int) Configuration::get($configKey);
                if ($categoryId <= 0) {
                    $categoryId = (int) getenv($configKey);
                }
            }
        }
        if ($categoryId <= 0 && isset($_SERVER['REQUEST_URI'])) {
            if (preg_match('#/categories/(\d+)/articles#', $_SERVER['REQUEST_URI'], $m)) {
                $categoryId = (int) $m[1];
            }
        }

        if ($categoryId <= 0) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Missing category']);
            exit;
        }

        list($page, $limit) = $this->validatePagination();
        $related = Tools::getValue('related');
        $relatedId = $related !== null ? (int) $related : null;

        $cacheKey = sprintf('growset2_category_%d_%d_%d', $categoryId, $page, $limit);
        $ttl = 300;

        $this->jsonResponse($cacheKey, $ttl, function () use ($categoryId, $page, $limit, $relatedId) {
            $provider = new ProductProvider();
            return $provider->getCategoryArticles($categoryId, $page, $limit, $relatedId);
        });
    }
}
