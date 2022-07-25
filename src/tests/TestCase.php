<?php

namespace Tests;

use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase,CreatesApplication , SeedDatabase;

    public function setUp() : void
    {
        parent::setUp();
        SeedDatabaseState::$seeders = [RoleAndPermissionSeeder::class];
        $this->seedDatabase();
    }
}
