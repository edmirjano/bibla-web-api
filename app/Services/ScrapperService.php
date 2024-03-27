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
    private string $url = "";
    private int $chapterCount;
    private int $bookId = 0;
    private array $bookContent = [];

    public function handle()
    {
        $browser = new HttpBrowser(HttpClient::create());
        $urls = $this->readfile();
        $this->content = [];

        foreach ($urls as $index => $url) {
            $book = Str::between($url, '/7/', '.');
            $newUrl = explode('.', $book)[0];

            if ($this->url != $newUrl) {
                $this->bookId++;
                $this->chapterCount = 0;
                $this->url=$newUrl;
            }
            $this->chapterCount++;

            $bookName = $this->scrape($browser, $index, $url);
            $this->bookContent[$this->bookId]['Id'] = $this->bookId;
            $this->bookContent[$this->bookId]['Name'] = $bookName;
            $this->bookContent[$this->bookId]['Total_Chapters'] = $this->chapterCount;

        }
        $bookData = json_encode($this->bookContent, JSON_PRETTY_PRINT);
        $jsonData = json_encode($this->content, JSON_PRETTY_PRINT);
        Storage::disk('public')->put('scrapper/book.json', $bookData);

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
        $this->content[$index]['Id'] = $index + 1;
        $this->content[$index]['Id_Book'] = $this->bookId;

        $crawler->filter('h1')->each(function ($node) use ($index) {
            $this->content[$index]['Name'] = $node->html();
            $this->content[$index]['Slug'] = Str::slug($node->html());
        });

        $crawler->filter('.ChapterContent_chapter__uvbXo')->each(function ($node) use ( $index) {
            $this->content[$index]['Content'] = $this->content[$index]['Content']??"".$node->html();
        });
        $this->content[$index]['url'] = $url;
        return preg_replace('/\d+/', '', $this->content[$index]['Name']);
    }


}
