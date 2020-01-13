<?php

namespace App\Http\Controllers;

use App\Cities;
use App\City;
use App\MusementApiService;
use App\XmlConverter;
use Illuminate\Http\Request;

/**
 * Class CityController
 * @package App\Http\Controllers
 */
class CityController extends Controller
{
    /**
     * @param Request $request
     */
    public function citiesIndex(Request $request)
    {
        $cities = new Cities(new City(new MusementApiService($request)));
        $citiesString = $cities->getCities();
        $xmlConverter = new XmlConverter($citiesString);
        $xmlSitemap = $xmlConverter->convertArrayToXml();
        dd($xmlSitemap);
    }
}
