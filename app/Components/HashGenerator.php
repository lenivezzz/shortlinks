<?php
declare(strict_types=1);

namespace App\Components;

use Carbon\CarbonInterface;
use Hashids\HashidsInterface;

class HashGenerator implements HashGeneratorInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashids;
    /**
     * @var CarbonInterface
     */
    private $carbon;

    /**
     * @param HashidsInterface $hashids
     * @param CarbonInterface $carbon
     */
    public function __construct(HashidsInterface $hashids, CarbonInterface $carbon)
    {
        $this->hashids = $hashids;
        $this->carbon = $carbon;
    }

    /**
     * @inheritDoc
     */
    public function generate() : string
    {
        return $this->hashids->encode($this->carbon->getPreciseTimestamp(4));
    }
}
