<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class ActivityControllerTest
 * @package Tests\Feature
 */
class ActivityControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_activity_controller_returns_activities_by_city_collection()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/cities/' . 1 . '/activities', $headers = ['Accept-Language:' . 'es-ES']);

        $response->assertOk();
        $response->json();
    }
}
