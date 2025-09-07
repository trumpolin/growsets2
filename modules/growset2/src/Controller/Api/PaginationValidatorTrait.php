<?php

namespace Growset2\Controller\Api;

use Tools;

trait PaginationValidatorTrait
{
    protected function validatePagination(): array
    {
        $page = (int) Tools::getValue('page', 1);
        $limit = (int) Tools::getValue('limit', 20);
        if ($page < 1 || $limit < 1 || $limit > 100) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Invalid page or limit']);
            exit;
        }
        return [$page, $limit];
    }
}
