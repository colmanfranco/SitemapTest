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
     * @return string
     */
    public function index(Request $request)
    {
        $cities = new Cities(new City(new MusementApiService($request)));
        $citiesString = $cities->getCities();
        $xmlSitemap = XmlConverter::fromApi($citiesString);
        return response($xmlSitemap, 200);
    }
}
