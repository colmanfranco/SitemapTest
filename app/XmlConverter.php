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
    private $activities;
    private $xmlDocument;
    private $activityLinkPriority = 0.5;
    private $xmlSitemap;
    private $startingTag = "http://www.sitemaps.org/schemas/sitemap/0.9";

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $activitiesArray
     */
    function __construct(Array $activitiesArray)
    {
        $this->xmlDocument = new DOMDocument("1.0", "UTF-8");
        $this->activities = $activitiesArray;
    }

    /**
     * @return string
     */
    function convertArrayToXml()
    {
        $this->buildActivitiesWithPriorities();
        $this->setXmlHeaders();
        return $this->xmlSitemap;
    }

    private function buildActivitiesWithPriorities()
    {
        $cityActivities = $this->activities['data'];
        foreach ($cityActivities as $activity)
        {
            $this->xmlSitemap = $this->xmlDocument->appendChild($this->xmlDocument->createElement('url'));
            $this->xmlSitemap->appendChild($this->xmlDocument->createElement('loc', $activity['url']));
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
    }
}
