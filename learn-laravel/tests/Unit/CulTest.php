<?php

namespace Tests\Unit;

use App\Models\MTest;
use PHPUnit\Framework\TestCase;

class CulTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertEquals(3, MTest::testCulAdd(1, 2));
    }

    public function test_example1()
    {
        $this->assertEquals(4, MTest::testCulAdd(1, 2));
    }

}
