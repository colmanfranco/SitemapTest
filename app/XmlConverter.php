<?php

namespace App;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;

/**
 * Class XmlConverter
 * @package App
 */
class XmlConverter extends Model
{
    private $sitemapContent;
    private $xmlDocument;
    private $activityLinkPriority = 0.5;
    private $xmlSitemap;
    private $startingTag = "http://www.sitemaps.org/schemas/sitemap/0.9";

    /**
     * Create a new Eloquent model instance.
     *
     * @param string $contentString
     */
    function __construct(string $contentString)
    {
        $this->xmlDocument = new DOMDocument("1.0", "UTF-8");
        $contentArray = $this->convertJsonToXml($contentString);

        if(!array_key_exists('data', $contentArray))
        {
            return $this->sitemapContent = $contentArray;
        }

        return $this->sitemapContent = $contentArray['data'];
    }

    /**
     * @param string $string
     * @return array
     */
    private function convertJsonToXml(string $string) : array
    {
        return json_decode($string, true);
    }

    /**
     * @return string
     */
    function convertArrayToXml()
    {
        $this->buildSitemapWithPriorities();
        $this->setXmlHeaders();
        return $this->xmlSitemap;
    }

    /**
     * @return void
     */
    private function buildSitemapWithPriorities() : void
    {
        foreach ($this->sitemapContent as $content)
        {
            $this->xmlSitemap = $this->xmlDocument->appendChild($this->xmlDocument->createElement('url'));
            $this->xmlSitemap->appendChild($this->xmlDocument->createElement('loc', $content['url']));
            $this->xmlSitemap->appendChild($this->xmlDocument->createElement('priority', $this->activityLinkPriority));
        }
    }

    private function setXmlHeaders() : void
    {
        $this->xmlDocument->formatOutput = true;
        $file_name = 'Musement_Sitemap.xml';
        $this->xmlDocument->save($file_name);
        header('Content-Type: application/xml, charset=utf-8');
        header('Content-Length: ' . filesize($file_name));
        readfile($file_name);
//        file_put_contents($this->xmlSitemap, $file_name);
    }
}
