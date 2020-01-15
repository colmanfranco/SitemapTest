<?php

namespace App;

use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class XmlConverter
 * @package App
 */
class XmlConverter extends Model
{
    private $sitemapContent;
    private $contentArray;
    private $xmlDocument;
    private $activityLinkPriority;
    private $xmlSitemap;

    /**
     * Create a new Eloquent model instance.
     *
     * @param string $contentString
     */
    private function __construct(string $contentString)
    {
        $this->xmlDocument = new DOMDocument("1.0", "UTF-8");
        $this->contentArray = $this->convertJsonToArray($contentString);
    }

    /**
     * @param string $string
     * @return object
     */
    static function fromApi(string $string) : object
    {
        $xmlConverter = new XmlConverter($string);
        return $xmlConverter->convertArrayToXml();
    }

    /**
     * @param string $string
     * @return array
     */
    private function convertJsonToArray(string $string) : array
    {
        return json_decode($string, true);
    }

    /**
     * @return object
     */
    private function convertArrayToXml() : object
    {
        $this->buildSitemapWithPriorities();
        $this->setXmlHeaders();
        $xmlSitemap = simplexml_import_dom($this->xmlSitemap);
        return $xmlSitemap;
    }

    /**
     * @return void
     */
    private function buildSitemapWithPriorities() : void
    {
        if($this->checkIfArrayKeyDataExists())
        {
            return;
        }

        $urlset = $this->xmlDocument->createElement('urlset');
        $urlset->setAttribute('xsi:schemaLocation', \config('url.urlset'));
        $this->xmlSitemap = $this->xmlDocument->appendChild($urlset);
        $this->activityLinkPriority = 0.5;
        $this->sitemapContent = $this->contentArray['data'];

        foreach ($this->sitemapContent as $content) {
            $url = $this->xmlSitemap->appendChild($this->xmlDocument->createElement('url'));
            $url->appendChild($this->xmlDocument->createElement('loc', $content['url']));
            $url->appendChild($this->xmlDocument->createElement('priority', $this->activityLinkPriority));
        }
    }

    /**
     * @return bool
     */
    private function checkIfArrayKeyDataExists() : bool
    {
        if(!array_key_exists('data', $this->contentArray))
        {
            $urlset = $this->xmlDocument->createElement('urlset');
            $urlset->setAttribute('xsi:schemaLocation', \config('url.urlset'));
            $this->xmlSitemap = $this->xmlDocument->appendChild($urlset);
            $this->activityLinkPriority = 0.7;
            $this->sitemapContent = $this->contentArray;

            foreach ($this->sitemapContent as $content) {
                $url = $this->xmlSitemap->appendChild($this->xmlDocument->createElement('url'));
                $url->appendChild($this->xmlDocument->createElement('id', $content['id']));
                $url->appendChild($this->xmlDocument->createElement('loc', $content['url']));
                $url->appendChild($this->xmlDocument->createElement('priority', $this->activityLinkPriority));
            }
            return true;
        }
        return false;
    }

    private function setXmlHeaders() : void
    {
        $this->xmlDocument->formatOutput = true;
        $file_name = 'Musement_Sitemap.xml';
        $this->xmlDocument->save($file_name);

        header('Content-Description: File Transfer');
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
//        exec('rm' . $file_name);
    }
}
