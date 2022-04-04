<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Images extends Component
{
    protected $images;


    public function getListeners()
    {
        return [
            'getImages' => 'getImages',
            'imageSelected' => 'imageSelected',
            'imageRefresh' => 'render'
        ];
    }

    public function imageSelected()
    {
        $this->dispatchBrowserEvent('image-selected');
        $this->reset();
        $this->render();
    }

    public function render()
    {
        return view('livewire.images', ['images' => $this->images ?? null]);
    }

    public function resetComponent()
    {
        $this->reset();
        $this->emitSelf('imageRefresh');
    }

    public function getImages($artist = null, $title = null)
    {
        $requestUrl = "http://musicbrainz.org/ws/2/release/?query=artist:" . $artist . " AND " . "release:" . $title;
        $cachedResults = Cache::get($requestUrl);
        if ($cachedResults) {
            $this->images = $cachedResults;
            $this->emitSelf('imageRefresh');
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
        $this->emitSelf('imageRefresh');
    }
}
