<?php

namespace App;

use App\Interfaces\ApiService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class MusementApiService
 * @package App
 */
class MusementApiService extends Model implements ApiService
{
    private $url = 'https://api.musement.com/api/v3';
    private $language;
    private $method;
    private $content;

    /**
     * Create a new Eloquent model instance.
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->method = $request->method();
        $this->language = $request->header('accept-language');
    }

    /**
     * @param $resourceUrl
     * @return false|string
     */
    public function fetchContent($resourceUrl) : string
    {
        $context = stream_context_create($this->httpHeaders());
        $this->content = file_get_contents($this->url . $resourceUrl, false, $context);
        return $this->content;
    }

    /**
     * @return array
     */
    private function httpHeaders() : array
    {
        return $headers = [
            'http' => [
                'method' => $this->method,
                'header' => ['Accept-Language:' . $this->language]
            ]
        ];
    }


}
