<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Http\Controllers\Release\Update\Images;
use App\Models\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class ImagesTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanReturnImages()
    {
        $this->withoutExceptionHandling();
        $release = Release::factory()->create([
            'artist' => 'Pink Floyd',
            'title' => 'Wish You Were Here'
        ]);
        $result = $this->get(route('api.release.images',  ['artist' => $release->artist, 'title'=>$release->title]));
        $result->assertSuccessful();
    }
}
