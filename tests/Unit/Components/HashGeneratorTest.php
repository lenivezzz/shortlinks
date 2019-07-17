<?php
declare(strict_types=1);

namespace Tests\Unit\Components;

use App\Components\HashGenerator;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Hashids\Hashids;
use Hashids\HashidsInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class HashGeneratorTest extends TestCase
{
    public function testGenerate() : void
    {
        /** @var HashidsInterface|MockObject $hashids */
        $hashids = $this->getMockBuilder(Hashids::class)
            ->disableOriginalConstructor()
            ->setMethods(['encode'])
            ->getMock();
        $hashids->expects($this->exactly(2))
            ->method('encode')
            ->withConsecutive([1], [2])
            ->willReturn('hash1', 'hash2');
        /** @var CarbonInterface|MockObject $carbon */
        $carbon = $this->getMockBuilder(Carbon::class)
            ->setMethods(['getPreciseTimestamp'])
            ->getMock();
        $carbon->method('getPreciseTimestamp')->willReturn(1, 2);

        $hashGenerator = new HashGenerator($hashids, $carbon);
        $this->assertEquals('hash1', $hashGenerator->generate());
        $this->assertEquals('hash2', $hashGenerator->generate());
    }
}
