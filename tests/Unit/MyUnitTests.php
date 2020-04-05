<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Category;
use App\News;

class MyUnitTests extends TestCase
{
    public function testCategory()
    {
        $this->assertIsArray(Category::getCategoryAll());
        $this->assertIsString(Category::getCategoryLink(1));
    }

    public function testNews()
    {
        $this->assertEquals(
            [0 => ['number' => 1], 5 => ['number' => 2], 10 => ['number' => 3]],
            News::addNumeration([0 => [], 5 => [], 10 => []])
        );
    }
}
