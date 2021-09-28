<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Images extends Controller
{
    public function __invoke(Request $request)
    {
        $artist = $request->input('artist');
        $title = $request->input('title');
        $requestUrl = "http://musicbrainz.org/ws/2/release/?query=artist:" . $artist . " AND " . "release:" . $title;
        $cachedResults = Cache::get($requestUrl);
        if ($cachedResults)
        {
            return new JsonResponse($cachedResults);
        }
        $response = Http::withHeaders(['accept' => 'application/json'])->get($requestUrl);
        $jsonArray = json_decode($response->body(), true);
        $releaseIds = collect($jsonArray['releases'])->sortBy('date')->where('score', '>','90')->pluck('id')->toArray();
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
        return new JsonResponse($imageArray);
    }
}
