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

    public function testItCanReturnASuccess()
    {
        $release = Release::factory()->create();
        $this->post(route('api.release.edit', $release->id))->assertSuccessful();
    }

    public function testItCanUpdateARelease()
    {
        $this->withoutExceptionHandling();
        $release = Release::factory()->create();
        $newArtist = $this->faker->name;
        $newTitle = $this->faker->sentence;
        $this->postJson(route('api.release.edit', $release->id), [
            'artist' => $newArtist,
            'title' => $newTitle,
        ])->assertSuccessful();
        $this->assertDatabaseHas('releases', [
            'id' => $release->id,
            'artist' => $newArtist,
            'title' => $newTitle,
        ]);
    }
}
