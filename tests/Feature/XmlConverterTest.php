<?php

namespace Tests\Feature;

use App\Activity;
use App\Interfaces\ApiService;
use App\MusementApiService;
use App\XmlConverter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use phpDocumentor\Reflection\Types\Object_;
use Tests\TestCase;

/**
 * Class ActivityTest
 * @package Tests\Feature
 */
class XmlConverterTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function test_if_xml_coverter_returns_an_xml_file()
    {
        $mockContent = '[{"id":57,"top":false,"name":"Amsterdam","code":"amsterdam","content":"Amsterdam est la capitale de la Hollande, un centre culturel et l\'une des destinations touristiques pr\u00e9f\u00e9r\u00e9es de l\'Europe. Ce n\'est peut-\u00eatre pas une ville \u00e9norme, mais ses caract\u00e9ristiques uniques suffisent \u00e0 attirer les touristes pour des excursions d\'une journ\u00e9e et de plus longues vacances.\u00c9tant sous le niveau de la mer, elle est d\u00e9finie comme la \" Venise du Nord \" en raison de ses nombreux canaux. Elle a \u00e9t\u00e9 construite en l\'an 1000 et a sauv\u00e9 la r\u00e9gion de l\'avanc\u00e9e des eaux.Parmi les attractions les plus populaires d\'Amsterdam, on trouve le Rijksmuseum avec le c\u00e9l\u00e8bre tableau de Rembrant \"The Night Watch\", le mus\u00e9e Van Gogh, la maison d\'Anne Frank, le mus\u00e9e Willet, les maisons Cromhout et bien d\'autres.","meta_description":"Trouvez avec Musement toutes les informations n\u00e9cessaires sur les mus\u00e9es d\'Amsterdam. D\u00e9couvrez par ailleurs le meilleur des tours et visites propos\u00e9s, r\u00e9servez vos billets \u00e0 l\'avance et \u00e9viter les files d\u2019attente !","more":"Les jeunes gens viennent dans cette ville pour sa vie nocturne et pour voir les \"Coffee Shops\" de renomm\u00e9e mondiale, tandis que les amateurs d\'art, d\'autre part, viennent profiter de certains des mus\u00e9es de la ville et de la belle architecture. La Hollande a r\u00e9alis\u00e9 avec succ\u00e8s sa propre architecture Renaissance au XVIIe si\u00e8cle, ce qui lui a donn\u00e9 une atmosph\u00e8re tr\u00e8s particuli\u00e8re.","weight":20,"latitude":52.374,"longitude":4.9,"country":{"id":124,"name":"Pays-Bas","iso_code":"NL"},"cover_image_url":"https:\/\/images.musement.com\/cover\/0002\/15\/amsterdam_header-114429.jpeg","url":"https:\/\/www.musement.com\/fr\/amsterdam\/","activities_count":181,"time_zone":"Europe\/Amsterdam","list_count":1,"venue_count":24,"show_in_popular":true}]';
        $musementApiService = Mockery::mock('App\MusementApiService', 'ApiService');
        $musementApiService->shouldReceive('fetchContent')->andReturn($mockContent);
        $mockedActivities = $musementApiService->fetchContent('fakeUrl');

        $xmlSitemap = XmlConverter::fromApi($mockedActivities);

        $this->assertInstanceOf(\SimpleXMLElement::class, $xmlSitemap);
        $this->assertObjectHasAttribute('url', $xmlSitemap);
    }
}
