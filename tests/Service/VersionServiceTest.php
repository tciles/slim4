<?php

namespace App\Test\Service;

use App\Service\VersionService;
use PHPUnit\Framework\TestCase;

/**
 * Class VersionServiceTest
 * @package App\Test\Service
 */
class VersionServiceTest extends TestCase
{
    /**
     * @var VersionService
     */
    private VersionService $stub;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->stub = new VersionService();
    }

    public function testGetVersion()
    {
        $result = $this->stub->getVersion();
        $this->assertEquals('v1', $result);
    }
}
