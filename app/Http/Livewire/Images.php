<?php

namespace App\Http\Livewire;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Images extends Component
{
    public $artist;
    public $title;
    public $images;
    public $isHidden = true;

    public function getListeners()
    {
        return ['openModal' => 'openModal'];
    }

    public function render()
    {
        return view('livewire.images');
    }

    public function openModal($artist, $title)
    {
        $this->isHidden = false;
        $this->artist = $artist;
        $this->title = $title;
    }

    public function getImages()
    {
        $requestUrl = "http://musicbrainz.org/ws/2/release/?query=artist:" . $this->artist . " AND " . "release:" . $this->title;
        $cachedResults = Cache::get($requestUrl);
        if ($cachedResults) {
            return new JsonResponse($cachedResults);
        }
        $response = Http::withHeaders(['accept' => 'application/json'])->get($requestUrl);
        $jsonArray = json_decode($response->body(), true);
        $releaseIds = collect($jsonArray['releases'])->sortBy('date')->where('score', '>', '90')->pluck('id')->toArray();
        $imageArray = [];
        foreach ($releaseIds as $releaseId) {
            $imageResponse = Http::withHeaders(['accept' => 'application/json'])->get("http://coverartarchive.org/release/$releaseId");
            $decodedResponse = json_decode($imageResponse, true);
            if ($decodedResponse) {
                $imageArray[] = collect($decodedResponse['images'])->where('front', 'true')->flatMap(function ($image) {
                    return [
                        'image' => $image['thumbnails']['large'],
                        'thumbnail' => $image['thumbnails']['small']
                    ];
                })->toArray();
            }
        }
        Cache::put($requestUrl, $imageArray);
        $this->images = $imageArray;
    }
}
