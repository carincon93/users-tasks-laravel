<?php

namespace App\Support;

class Pagination
{
    public static function make(
        int $offset,
        int $limit,
        int $count
    ): array {
        $limit = $limit ?: 10;

        // NEXT
        $nextOffset = $offset + $limit;
        $next = $nextOffset < $count
            ? ['offset' => $nextOffset, 'limit' => $limit]
            : null;

        // PREVIOUS
        $prevOffset = $offset - $limit;
        if ($prevOffset < 0) {
            $prevOffset = 0;
        }

        $previous = $offset > 0
            ? ['offset' => $prevOffset, 'limit' => $limit]
            : null;

        return compact('next', 'previous');
    }
}
