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

/**
 * Class ActivityTest
 * @package Tests\Feature
 */
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
        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?>
                        <urlset xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">
                            <url>
                              <loc>https://www.musement.com/us/milan/da-vinci-s-last-supper-skip-the-line-tickets-and-guided-tour-497/</loc>
                              <priority>0.5</priority>
                            </url>
                        </urlset>';
        $activitiesUrl = '/cities/' . $cityId . '/activities?limit=1';

        $musementApiService = Mockery::mock('App\MusementApiService', 'ApiService')->makePartial();
        $musementApiService->shouldReceive('fetchActivitiesByCity')->andReturn('allCityActivities');

        $mockedActivities = $musementApiService->fetchContent($activitiesUrl);
//        $decodedActivities = json_decode($mockedActivities, true);
//        dd($decodedActivities);
        $xmlConverter = new XmlConverter($mockedActivities);
        $xmlSitemap = $xmlConverter->convertArrayToXml();
        $this->assertXmlStringEqualsXmlString($expectedXml, $xmlSitemap);

    }
}
