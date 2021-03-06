<?php

namespace KenticoCloud\Tests\E2E;

use KenticoCloud\Delivery\Client;
use KenticoCloud\Delivery\QueryParams;

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function getClient($previewApiKey = null)
    {
        $projectId = '975bf280-fd91-488c-994c-2f04416e5ee3';
        if (is_null($previewApiKey)) {
            return new Client($projectId);
        } else {
            return new Client($projectId, $previewApiKey);
        }
    }
    
    public function testGetArticleItem()
    {
        $params = (new QueryParams())->codename('on_roasts');
        $client = $this->getClient();
        $item = $client->getItem($params);
        $this->assertEquals('f4b3fc05-e988-4dae-9ac1-a94aba566474', $item->system->id);
        $this->assertEquals('On Roasts', $item->elements['title']);
        /* $this->assertInternalType('integer', $item->system->last_modified);
        $this->assertInternalType('integer', $item->system->getLastModified()); */
    }

    public function testGetContentItem()
    {
        $params = (new QueryParams())->codename('home');
        $client = $this->getClient();
        $item = $client->getItem($params);
        $this->assertEquals('1bd6ba00-4bf2-4a2b-8334-917faa686f66', $item->system->id);
        /* $this->assertInternalType('integer', $item->system->last_modified);
        $this->assertInternalType('integer', $item->system->getLastModified()); */
    }

    public function testGetContentTypesLimit_TwoTypes()
    {
        $params = (new QueryParams())->limit(2);
        $client = $this->getClient();
        $types = $client->getTypes($params);

        $this->assertTrue(count($types) === 2);
    }

    public function testGetContentType_TypeNotExist()
    {
        $params = (new QueryParams())->codename('inexistent-codename');
        $client = $this->getClient();
        $type = $client->getType($params);

        $this->assertNull($type);
    }

    public function testGetContentType_FirstRecord()
    {
        $params = (new QueryParams())->limit(1);
        $client = $this->getClient();
        $type = $client->getType($params);

        $this->assertEquals("b2c14f2c-6467-460b-a70b-bca17972a33a", $type->system->id);
    }

    public function testGetContentTypesCount()
    {
        $client = $this->getClient();
        $types = $client->getTypes(null);

        $this->assertGreaterThan(1, count($types));
    }

    public function testGetPreviewApiEmpty()
    {
        $params = (new QueryParams())->codename('amsterdam');
        $client = $this->getClient();
        $item = $client->getItem($params);
        $this->assertNull($item);
    }

    public function testGetPreviewApiPresent()
    {
        $params['system.codename'] = 'amsterdam';
        $client = $this->getClient('ew0KICAiYWxnIjogIkhTMjU2IiwNCiAgInR5cCI6ICJKV1QiDQp9.ew0KICAidWlkIjogInVzcl8wdk4xUTA1bks2YmlyQVQ2TU5wdkkwIiwNCiAgImVtYWlsIjogInBldHIuc3ZpaGxpa0BrZW50aWNvLmNvbSIsDQogICJwcm9qZWN0X2lkIjogIjk3NWJmMjgwLWZkOTEtNDg4Yy05OTRjLTJmMDQ0MTZlNWVlMyIsDQogICJqdGkiOiAibzhUdkc0OHFqX0ZUSWplVCIsDQogICJ2ZXIiOiAiMS4wLjAiLA0KICAiZ2l2ZW5fbmFtZSI6ICJQZXRyIiwNCiAgImZhbWlseV9uYW1lIjogIlN2aWhsaWsiLA0KICAiYXVkIjogInByZXZpZXcuZGVsaXZlci5rZW50aWNvY2xvdWQuY29tIg0KfQ.wd7_nOYInsdsoh9-0R43FnDQuVk_azPaYze7Ghxv43I');
        $item = $client->getItem($params);
        $this->assertEquals('e844a6aa-4dc4-464f-8ae9-f9f66cc6ab61', $item->system->id);
    }

    
    public function testGetContentItems()
    {
        $params = (new QueryParams())->type('article')->depth(2);
        $client = $this->getClient();
        $items = $client->getItems($params);
        $this->assertGreaterThan(1, count($items->items));
        //$this->assertGreaterThan(1, count($items->modularContent));
    }

    public function testDepth()
    {
        $params = (new QueryParams())->type('article')->depth(0);
        $client = $this->getClient();
        $items = $client->getItems($params);
        //$this->assertEquals(0, count($items->modularContent));
        $this->assertTrue(true);    # TODO: Add real assert here.
    }

    public function testModularContentResolution()
    {
        $params = (new QueryParams())->codename('home');
        $client = $this->getClient();
        $items = $client->getItems($params);
        //$this->assertEquals('home_page_hero_unit', $items->items['home']->elements['hero_unit']['home_page_hero_unit']->system->codename);
    }

    /* public function testAssets()
    {
        $params['system.codename'] = 'home_page_hero_unit';
        $client = $this->getClient();
        $item = $client->getItem($params);
    }
 */
    public function testQueryParams()
    {
        $params = (new QueryParams())->type('article', 'home')->depth(0)->language('es-ES')->orderDesc('system.name')->limit(2);
        $client = $this->getClient();
        $items = $client->getItems($params);
        $this->assertGreaterThan(1, count($items->items));
    }
}
