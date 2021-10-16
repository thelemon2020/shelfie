<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Images extends Component
{
    public $images;
    public $activeImage;


    public function getListeners()
    {
        return [
            'getImages' => 'getImages',
            'nextImage' => 'nextImage',
            'previousImage' => 'previousImage'
        ];
    }

    public function selectImage()
    {
        $this->emitUp('imageSelected', $this->images[$this->activeImage]['image'], $this->images[$this->activeImage]['thumbnail']);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.images', ['image' => $this->images[$this->activeImage] ?? null]);
    }

    public function getImages($artist = null, $title = null)
    {
        $this->activeImage = 0;
        $requestUrl = "http://musicbrainz.org/ws/2/release/?query=artist:" . $artist . " AND " . "release:" . $title;
        $cachedResults = Cache::get($requestUrl);
        if ($cachedResults) {
            $this->images = $cachedResults;
            return;
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

    public function nextImage()
    {
        if ($this->activeImage === count($this->images) - 1) {
            $this->activeImage = 0;
        } else {
            $this->activeImage++;
        }
        $this->render();
    }

    public function previousImage()
    {
        if ($this->activeImage === 0) {
            $this->activeImage = count($this->images) - 1;
        } else {
            $this->activeImage--;
        }
        $this->render();
    }

}
