<?php

namespace Growset\Controller\Api;

use Cache;

trait JsonResponseTrait
{
    private function jsonResponse(string $cacheKey, int $ttl, callable $callback): void
    {
        $content = Cache::retrieve($cacheKey);
        if (!$content) {
            $data = $callback();
            $content = json_encode($data);
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

