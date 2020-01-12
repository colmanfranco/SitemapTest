<?php

namespace App;

use App\Interfaces\ApiService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App
 */
class City extends Model
{
    private $musementApiService;
    private $citiesUrl = '/cities?limit=3';

    /**
     * Create a new Eloquent model instance.
     *
     * @param ApiService $musementApiService
     */
    public function __construct(ApiService $musementApiService)
    {
        $this->musementApiService = $musementApiService;
    }

    public function getAllCities()
    {
        return $this->musementApiService->fetchContent($this->citiesUrl);
    }
}
