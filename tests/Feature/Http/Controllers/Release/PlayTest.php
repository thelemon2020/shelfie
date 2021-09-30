<?php

namespace Http\Controllers\Release;

use App\Models\Release;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanSetPlayedAtAndTimesPlayed()
    {
        Carbon::setTestNow();
        $release = Release::factory()->create();

        $this->getJson(route('api.release.play', $release->id))
            ->assertSuccessful();

        $this->assertDatabaseHas('releases', [
            'artist' => $release->artist,
            'last_played_at' => Carbon::now(),
            'times_played' => $release->times_played + 1,
        ]);
    }
}
