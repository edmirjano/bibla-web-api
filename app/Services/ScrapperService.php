<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class ScrapperService{



    public function handle()
    {
        $browser = new HttpBrowser(HttpClient::create());
        $urls = $this->readfile();
        foreach ($urls as $index=>$url) {
            if($index < 1)
            $this->scrape($browser, $url);
        }
    }


    public function readfile(){
        $fileContent=Storage::disk('public')->get('scrap.csv');
        $fileContent=explode("\n",$fileContent);
        return array_filter($fileContent);
    }

    public function scrape($browser, $url){
        $crawler = $browser->request('GET', $url);
//        ChapterContent_reader__Dt27r
        $crawler->filter('.ChapterContent_chapter__uvbXo')->each(function ($node) {
            dd($node->html());
        });
    }


    //to see edi
    public function scrapeBooks($browser, $url){
        $crawler = $browser->request('GET', $url);
        $crawler->filterXPath('//*[starts-with(@id, "headlessui-popover-panel-")]')->each(function ($node) {
            dd($node->html());
        });
    }



}
