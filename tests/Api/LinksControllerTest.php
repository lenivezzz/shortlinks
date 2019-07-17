<?php
declare(strict_types=1);

namespace Tests\Api;

use App\Link;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LinksControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreate() : void
    {
        $this->get('/api/v1/links')->seeStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->post('/api/v1/links', ['url' => ''])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->post('/api/v1/links', ['url' => 'wrong_url_format'])
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $url = Factory::create()->url;
        $this->post('/api/v1/links', ['url' => $url])
            ->seeStatusCode(Response::HTTP_CREATED)
            ->seeJsonContains(['full_url' => $url]);
    }

    public function testShow() : void
    {
        $uri = Factory::create()->word;
        $url = Factory::create()->url;
        Link::query()->create([
            'short_uri' => $uri,
            'full_url' => $url,
        ]);
        $this->get('/api/v1/links/' . $uri)->seeStatusCode(200)
            ->seeJsonContains(['full_url' => $url]);
    }
}
