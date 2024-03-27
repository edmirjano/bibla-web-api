<?php

namespace App\Services;

use Hamcrest\Thingy;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class ScrapperService
{


    private array $content;

    public function handle()
    {
        $browser = new HttpBrowser(HttpClient::create());
        $urls = $this->readfile();
        $this->content = [];
        foreach ($urls as $index => $url) {
                $this->scrape($browser, $index, $url);
        }
        $jsonData = json_encode($this->content, JSON_PRETTY_PRINT);

        Storage::disk('public')->put('scrapper/chapter.json', $jsonData);
    }


    public function readfile()
    {
        $fileContent = Storage::disk('public')->get('scrap.csv');
        $fileContent = explode("\n", $fileContent);
        return array_filter($fileContent);
    }

    public function scrape($browser, $index, $url)
    {
        $crawler = $browser->request('GET', $url);
        $this->content[$index]['Id'] = $index+1;
        $this->content[$index]['Id_Book'] = 1;

        $crawler->filter('h1')->each(function ($node) use ($index) {
            $this->content[$index]['Name'] = $node->html();
            $this->content[$index]['Slug'] = Str::slug ($node->html());
        });
        $crawler->filter('.ChapterContent_content__RrUqA')->each(function ($node) use ( $index) {
            $this->content[$index]['Content'][] = $node->html();
        });
        $this->content[$index]['url'] = $url;

    }


    //to see edi
    public function scrapeBooks($browser, $url)
    {
        $crawler = $browser->request('GET', $url);
        $crawler->filterXPath('//*[starts-with(@id, "headlessui-popover-panel-")]')->each(function ($node) {
            dd($node->html());
        });
    }


}
