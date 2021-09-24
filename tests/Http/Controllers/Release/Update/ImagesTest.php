<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Http\Controllers\Release\Update\Images;
use App\Models\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Throwable;

class ImagesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testItCanReturnImages()
    {

        $firstImageUrl = $this->faker->url;
        $secondImageUrl = $this->faker->url;
        $fakeUrls = [
            [
                'image'=>$firstImageUrl,
                'thumbnails' =>['small' => $secondImageUrl],
                'front' => 'true'
            ],
        ];
//        Http::fake([
//            'http://musicbrainz.org/*' => Http::response(['releases'=>['id' => $this->faker->uuid], 'date'=>$this->faker->date]),
//            'http://coverartarchive.org/*' => Http::response(['images'=>$fakeUrls])
//        ]);
        $release = Release::factory()->create([
            'artist' => 'Pink Floyd',
            'title' => 'Wish You Were Here'
        ]);
        $result = $this->get(route('api.release.images',  ['artist' => $release->artist, 'title'=>$release->title]));
        $result->assertSuccessful();
        $result->assertJson([[
            'image' => $firstImageUrl,
            'thumbnail' => $secondImageUrl,
            ]]);
    }

    public function testItCanStoreAndRetrieveImagesFromCache()
    {
        $firstImageUrl = $this->faker->url;
        $secondImageUrl = $this->faker->url;
        $fakeUrls = [
            [
                'image'=>$firstImageUrl,
                'thumbnail' => $secondImageUrl,
            ],
        ];
        $release = Release::factory()->create([
            'artist' => 'Pink Floyd',
            'title' => 'Wish You Were Here'
        ]);
        $requestUrl = "http://musicbrainz.org/ws/2/release/?query=artist:" . $release->artist . "AND" . "release:" . $release->title;
        $result = $this->get(route('api.release.images',  ['artist' => $release->artist, 'title'=>$release->title]));

        $cachedResults = Cache::get($requestUrl);

        $result->assertJson($cachedResults);
        $secondResult = $this->get(route('api.release.images',  ['artist' => $release->artist, 'title'=>$release->title]));
        $this->assertEquals($result->content(), $secondResult->content());
    }
}
