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
        $allCities = $cities->getCities();
        $this->convertJsonToXml($allCities);
    }

    /**
     * @param $array
     * @return string
     */
    private function convertJsonToXml($array)
    {
        $citiesArray = json_decode($array, true);
        dd($citiesArray);
        $xmlConverter = new XmlConverter($citiesArray);
        $xmlSitemap = $xmlConverter->convertArrayToXml();
        return $xmlSitemap;
    }
}
