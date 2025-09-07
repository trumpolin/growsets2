<?php

namespace Growset2\Controller\Api;

use Cache;
use JsonException;

trait JsonResponseTrait
{
    private function jsonResponse(string $cacheKey, int $ttl, callable $callback): void
    {
        $content = Cache::retrieve($cacheKey);
        if (!$content) {
            $data = $callback();
            try {
                $content = json_encode($data, JSON_THROW_ON_ERROR);
                Cache::store($cacheKey, $content, $ttl);
            } catch (JsonException $e) {
                error_log($e->getMessage());
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Internal Server Error']);
                exit;
            }
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

