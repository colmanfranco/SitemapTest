<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Activity;
use App\MusementApiService;
use App\XmlConverter;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 * @package App\Http\Controllers
 */
class ActivityController extends Controller
{
    /**
     * @param Request $request
     * @param $cityId
     * @return string
     */
    public function activitiesIndex(Request $request, $cityId)
    {
        $activities = new Activities(new Activity(new MusementApiService($request), $cityId));
        $activitiesString = $activities->getCityActivities();
        $xmlConverter = new XmlConverter($activitiesString);
        $xmlSitemap = $xmlConverter->convertArrayToXml();
        dd($xmlSitemap);            //TODO FIX SITEMAP RETURN TO BROWSER
        return response($xmlSitemap, 200)->header('Content-Type', 'text/xml');
    }
}
