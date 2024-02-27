<?php

namespace App\Http\Controllers;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class ScrapeController extends Controller
{
    public function scrape()
    {
        $browser = new HttpBrowser(HttpClient::create());

        $crawler = $browser->request('GET', 'https://www.bible.com/bible/7/GEN.1.ALBB');

        $crawler->filter('.ChapterContent_reader__Dt27r')->each(function ($node) {
            print $node->text()."\n";
        });
    }
}