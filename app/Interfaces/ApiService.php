<?php

namespace App\Interfaces;

/**
 * Interface ApiService
 * @package App\Interfaces
 */
interface ApiService
{
    /**
     * @param $resourceUrl
     * @return mixed
     */
    public function fetchContent($resourceUrl);
}
