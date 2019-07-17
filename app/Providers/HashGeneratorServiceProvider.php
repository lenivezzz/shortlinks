<?php
declare(strict_types=1);

namespace App\Providers;

use App\Components\HashGenerator;
use App\Components\HashGeneratorInterface;
use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Support\ServiceProvider;

class HashGeneratorServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register() : void
    {
        $this->app->bind(
            HashGeneratorInterface::class,
            HashGenerator::class
        );

        $this->app->bind(
            HashidsInterface::class,
            function () {
                return new Hashids(getenv('HASH_SALT'), getenv('HASH_MIN_LENGTH'));
            }
        );
    }
}
