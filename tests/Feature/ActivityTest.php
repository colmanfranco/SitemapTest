<?php

namespace Tests\Feature;

use App\Activity;
use App\Interfaces\ApiService;
use App\MusementApiService;
use App\XmlConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_if_xml_coverter_returns_an_xml_file()
    {
        $cityId = 1;
        $activitiesUrl = '/cities/' . $cityId . '/activities?limit=1';
        $musementApiService = Mockery::mock('App\MusementApiService', 'App\Interfaces\ApiService')->makePartial();
        $musementApiService->shouldReceive('fetchActivitiesByCity')->andReturn('allCityActivities');
        
        $mockedActivities = $musementApiService->fetchActivitiesByCity($activitiesUrl);
        $decodedActivities = json_decode($mockedActivities, true);
        $xmlConverter = new XmlConverter($decodedActivities);
        

    }
}
