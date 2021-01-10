<?php

namespace App\Test\TestCase\Service;

use App\Service\VersionService;
use PHPUnit\Framework\TestCase;

/**
 * Class VersionServiceTest.
 */
class VersionServiceTest extends TestCase
{
    /**
     * @var VersionService
     */
    private VersionService $stub;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->stub = new VersionService();
    }

    public function testGetVersion(): void
    {
        $result = $this->stub->getVersion();
        $this->assertEquals('v1', $result);
    }
}
