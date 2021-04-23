<?php

declare(strict_types=1);

namespace App\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * Trait FetchResponseContentsTrait.
 */
trait FetchResponseContentsTrait
{
    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function fetchResponseContents(ResponseInterface $response): array
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        if (empty($contents)) {
            throw new \RuntimeException('Empty response contents');
        }

        return $contents;
    }
}
