<?php
declare(strict_types=1);

namespace App\Providers;

use App\Repositories\LinkDbRepository;
use App\Repositories\LinkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register() : void
    {
        $this->app->bind(LinkRepositoryInterface::class, LinkDbRepository::class);
    }
}
