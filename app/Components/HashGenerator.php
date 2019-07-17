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
     * @todo replace with more reliable algorithm
     * @inheritDoc
     */
    public function generate() : string
    {
        return $this->hashids->encode((int) $this->carbon::now()->getPreciseTimestamp(4));
    }
}
