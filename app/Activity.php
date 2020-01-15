<?php

namespace App;

use App\Interfaces\ApiService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * @package App
 */
class Activity extends Model
{
    private $musementApiService;
    private $activitiesUrl;

    /**
     * Create a new Eloquent model instance.
     *
     * @param ApiService $musementApiService
     * @param $cityId
     */
    function __construct(ApiService $musementApiService, int $cityId)
    {
        $this->musementApiService = $musementApiService;
        $this->activitiesUrl = '/cities/' . $cityId . '/activities?limit=20';
    }

    /**
     * @return mixed
     */
    public function getActivitiesByCity() : string
    {
        return $this->musementApiService->fetchContent($this->activitiesUrl);
    }
}
