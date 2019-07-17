<?php
declare(strict_types=1);

namespace App\Components;

interface HashGeneratorInterface
{
    /**
     * @return string
     */
    public function generate() : string;
}
