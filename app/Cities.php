<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cities
 * @package App
 */
class Cities extends Model
{
    private $cities;

    /**
     * Create a new Eloquent model instance.
     *
     * @param City $city
     */
    public function __construct(City $city)
    {
        $this->cities = $city;
    }

    /**
     * @return mixed
     */
    public function getCities()
    {
        return $this->cities->getAllCities();
    }
}
