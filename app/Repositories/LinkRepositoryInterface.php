<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Link;

interface LinkRepositoryInterface
{
    /**
     * @param string $uri
     * @return Link
     */
    public function findByShortUri(string $uri) : Link;

    /**
     * @param string $shortUri
     * @param string $fullUrl
     * @param string|null $expiresAt
     * @return Link
     */
    public function create(string $shortUri, string $fullUrl, string $expiresAt = null) : Link;
}
