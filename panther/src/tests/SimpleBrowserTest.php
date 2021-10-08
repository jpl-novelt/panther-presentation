<?php

declare(strict_types=1);

namespace Tests;

use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

class SimpleBrowserTest extends PantherTestCase
{
    public function testNovelT(): void
    {
        $client = Client::createChromeClient();

        $client->request('GET', 'https://novel-t.ch/');
        $client->waitFor('li:nth-of-type(3) > .nav-link');
        $client->takeScreenshot('page-homepage.png');
        $client->clickLink('Our Focus');

        // Wait for an element to be present in the DOM (even if hidden)
        $crawler = $client->waitForElementToContain('.header-title','Our Focus');

        $headerTitle = $crawler->filter('.header-title')->text();
        $this->assertEquals("Our Focus", $headerTitle);
        $client->takeScreenshot('page-our-focus.png');

        $crawler = $client->waitFor('app-focus > .our-focus-landing');

        $crawler->filter('div:nth-of-type(3) > div:nth-of-type(2) > .solution-part-2 > .solution-2')->click();
        $client->takeScreenshot('page-integration.png');

        $p = $crawler->filter('.focus-para > p')->text();
        $this->assertEquals('Power knowledge-driven decisions with integrated, centralized and harmonized data', $p);
    }
}