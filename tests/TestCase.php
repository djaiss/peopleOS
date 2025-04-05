<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    /**
     * Set up the test environment.
     *
     * This method is called before each test is executed. It ensures that
     * the parent setup method is called and prevents external HTTP requests
     * during the test execution by using the Http::preventStrayRequests() method.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    final public function assertArrayHasKeys(array $array, array $keys): void
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array);
        }
    }
}
