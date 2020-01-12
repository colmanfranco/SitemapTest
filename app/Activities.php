<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activities
 * @package App
 */
class Activities extends Model
{
    private $activities;

    /**
     * Create a new Eloquent model instance.
     *
     * @param Activity $activity
     */
    function __construct(Activity $activity)
    {
        $this->activities = $activity;
    }

    /**
     * @return mixed
     */
    public function getCityActivities() : string
    {
        return $this->activities->getActivitiesByCity();
    }
}
