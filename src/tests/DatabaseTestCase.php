<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

abstract class DatabaseTestCase extends TestCase {
    use RefreshDatabase;
}
