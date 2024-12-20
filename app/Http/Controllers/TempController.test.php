<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\TempController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TempControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new TempController();
    }
}
