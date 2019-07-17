<?php
declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Link;
use App\Repositories\LinkDbRepository;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class LinkDbRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var LinkDbRepository
     */
    private $repository;

    /**
     * @inheritDoc
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->repository = new LinkDbRepository();
    }

    public function testCreate() : void
    {
        $uri = 'exist-uri';
        $fullUrl = 'https://fakeurl.fakedomain';
        Link::query()->create([
            'short_uri' => $uri,
            'full_url' => $fullUrl,
        ]);
        $link = $this->repository->findByShortUri($uri);

        $this->assertEquals($fullUrl, $link->full_url);

        $this->expectException(ModelNotFoundException::class);
        $this->repository->findByShortUri('not-exists-uri');
    }

    public function testFindByShortUrl() : void
    {
        $uri = Factory::create()->word;
        $fullUrl = Factory::create()->url;
        $expiresAt = Factory::create()->dateTime->format('Y-m-d H:i:s');
        $link = $this->repository->create($uri, $fullUrl, $expiresAt);
        $this->assertEquals(
            [$uri, $fullUrl, $expiresAt],
            [$link->short_uri, $link->full_url, $link->expires_at]
        );

        Link::query()->where(['short_uri' => $uri])->firstOrFail();
    }
}
