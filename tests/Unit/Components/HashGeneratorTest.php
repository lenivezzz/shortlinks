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
            ->withConsecutive([10000], [20000])
            ->willReturn('hash1', 'hash2');
        /** @var CarbonInterface|MockObject $carbon */

        $carbon = Carbon::now();
        $hashGenerator = new HashGenerator($hashids, $carbon);
        Carbon::setTestNow('1970-01-01 00:00:01');
        $this->assertEquals('hash1', $hashGenerator->generate());
        Carbon::setTestNow('1970-01-01 00:00:02');
        $this->assertEquals('hash2', $hashGenerator->generate());
    }
}
