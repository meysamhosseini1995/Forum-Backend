<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication , SeedDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->seedDatabase();
    }
}
