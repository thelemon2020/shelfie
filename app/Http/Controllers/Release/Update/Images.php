<?php

namespace App\Http\Controllers\Release\Update;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Images extends Controller
{
    public function __invoke(Request $request)
    {
        $artist = $request->input('artist');
        $title = $request->input('title');
        $response = Http::withHeaders(['accept' => 'application/json'])->get("http://musicbrainz.org/ws/2/release/?query=artist:" . $artist . "AND" . "release:" . $title);
        $jsonArray = json_decode($response->body(), true);
        $releaseIds = collect($jsonArray['releases'])->sortBy('date')->pluck('id')->toArray();
        $imageArray = [];
        foreach ($releaseIds as $releaseId) {
            $imageResponse = Http::withHeaders(['accept' => 'application/json'])->get("http://coverartarchive.org/release/$releaseId");
            $decodedResponse = json_decode($imageResponse, true);
            if ($decodedResponse) {
                $imageArray[] = collect($decodedResponse['images'])->where('front', 'true')->flatMap(function ($image) {
                    return [
                        'image' => $image['image'],
                        'thumbnail' => $image['thumbnails']['small']
                    ];
                })->toArray();
            }
        }
        return new JsonResponse($imageArray);
    }
}
