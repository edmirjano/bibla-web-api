<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class ScrapperService
{
    private array $content;
    private string $url = "";
    private int $chapterCount;
    private int $bookId = 59;
    private array $bookContent = [];

    public function handle()
    {
        // $this -> incrementIdsInJson("scrapper/perupdatealbb.json", "scrapper/perupdatealbb3.json", "scrapper/nocontent.json");
        $browser = new HttpBrowser(HttpClient::create());
        $urls = $this->readFile();
        $this->content = [];

        foreach ($urls as $index => $url) {
            try {
                $index += 1133;
                dump($url);
                $book = Str::between($url, '/7/', '.');
                $newUrl = explode('.', $book)[0];

                if ($this->url != $newUrl) {
                    $this->bookId++;
                    $this->chapterCount = 0;
                    $this->url = $newUrl;
                }
                $this->chapterCount++;

                $bookName = $this->scrape($browser, $index, $url);
                $this->bookContent[$this->bookId-1]= [
                    'Id' => $this->bookId,
                    'Name' => $bookName,
                    'Total_Chapters' => $this->chapterCount,
                ];

            } catch (\Exception $exception) {
                Log::error("Error writing content of url {$url} with message: {$exception->getMessage()}");
            }

        }
        $this->saveScrapperFiles();
    }

    public function my_json_decode($s) {
        $s = str_replace(
            array('"',  "'"),
            array('\"', '"'),
            $s
        );
        $s = preg_replace('/(\w+):/i', '"\1":', $s);
        return json_decode(sprintf('{%s}', $s));
    }
    public function incrementIdsInJson($inputFilePath, $outputFilePath, $noContentFilePath)
    {
        try {
            // Read the JSON file
            $jsonContent = Storage::disk('public')->get($inputFilePath);
            $dataArray = json_decode($jsonContent, true);

            // Check if the JSON content is an array
            if (!is_array($dataArray)) {
                throw new \Exception("Invalid JSON format.");
            }

            // Array to hold items without "Content" property
            $noContentItems = [];

            // Increment the Id field for each object in the array and find items without "Content"
            foreach ($dataArray as &$item) {
                if (!isset($item['Name'])) {
                    dump($item);
                    $noContentItems[] = $item;
                }
                if (isset($item['Id'])) {
                    $item['Id'] += 1;
                }
            }

            // Encode the modified array back to JSON
            $modifiedJsonContent = json_encode($dataArray, JSON_PRETTY_PRINT);

            // Save the modified JSON to the original output file
            Storage::disk('public')->put($outputFilePath, $modifiedJsonContent);

            // Encode the noContentItems array to JSON
            $noContentJsonContent = json_encode($noContentItems, JSON_PRETTY_PRINT);

            // Save the noContentItems JSON to a new file
            Storage::disk('public')->put($noContentFilePath, $noContentJsonContent);

            echo "Successfully incremented Ids and saved to {$outputFilePath}\n";
            echo "Items without 'Content' property saved to {$noContentFilePath}\n";
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function readFile()
    {
        $fileContent = Storage::disk('public')->get('scrap.csv');
        $fileContent = explode("\n", $fileContent);
        return array_filter($fileContent);
    }

    public function scrape($browser, $index, $url): array|string|null
    {
        $crawler = $browser->request('GET', $url);
        $this->content[$index]['Id'] = $index + 1;
        $this->content[$index]['Id_Book'] = $this->bookId;

        $crawler->filter('h1')->each(function ($node) use ($index) {
            $this->content[$index]['Name'] = $node->html();
            $this->content[$index]['Slug'] = Str::slug($node->html());
        });

        $crawler->filter('.ChapterContent_chapter__uvbXo')->each(function ($node) use ($index) {
            $this->content[$index]['Content'] = $this->content[$index]['Content'] ?? "" . $node->html();
        });
        $this->content[$index]['url'] = $url;
        return preg_replace('/\d+$/', '', $this->content[$index]['Name']);
    }

    private function saveScrapperFiles(): void
    {
        try {
            $bookData = json_encode(array_values($this->bookContent), JSON_PRETTY_PRINT);
            $jsonData = json_encode(array_values($this->content), JSON_PRETTY_PRINT);

            Storage::disk('public')->put('scrapper/book.json', $bookData);
            Storage::disk('public')->put('scrapper/chapter.json', $jsonData);
            Log::info("Success saving Scrapper fils in storage . inside /scrapper");
        } catch (\Exception $exception) {
            Log::error("Error saving scrapper  files with messages {$exception->getMessage()}");
        }
    }
}
