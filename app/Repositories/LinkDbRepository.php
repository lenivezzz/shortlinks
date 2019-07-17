<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Link;

class LinkDbRepository implements LinkRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function findByShortUri(string $uri) : Link
    {
        return Link::query()->where(['short_uri' => $uri])->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function create(string $shortUri, string $fullUrl, string $expiresAt = null) : Link
    {
        return Link::query()->create([
            'short_uri' => $shortUri,
            'full_url' => $fullUrl,
            'expires_at' => $expiresAt,
        ]);
    }
}
