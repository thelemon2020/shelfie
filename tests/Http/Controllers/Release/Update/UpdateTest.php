<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Models\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use withFaker;
    use RefreshDatabase;

    public function testItCanReturnARedirect()
    {
        $release = Release::factory()->create();
        $this->post(route('api.release.edit', $release->id))->assertRedirect();
    }

    public function testItCanUpdateARelease()
    {
        $release = Release::factory()->create();
        $newArtist = $this->faker->name;
        $newTitle = $this->faker->sentence;
        $this->postJson(route('api.release.edit', $release->id), [
            'artist' => $newArtist,
            'title' => $newTitle,
        ]);
        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'artist' => $newArtist,
            'title' => $newTitle,
        ]);

    }

    public function testItCanChangeShelfOrderCorrectly()
    {
        $releases = Release::factory()->count(10)->create();
        $releaseToChange = $releases[3];
        dump($releaseToChange->toArray());
        $this->postJson(route('api.release.edit', $releaseToChange->id), [
            'shelf_order' => '7',
        ]);
        $reorderedReleases = Release::all()->sortByDesc('shelf_order');
        dump($releaseToChange->fresh()->toArray());
        dump($reorderedReleases[3]->toArray());
        $this->assertEquals($releaseToChange->fresh()->toArray(), $reorderedReleases[3]->toArray());
    }
}
