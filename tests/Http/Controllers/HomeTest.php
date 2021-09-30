<?php

namespace Tests\Http\Controllers;

use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{

    use RefreshDatabase;

    public function testItCanDisplayCorrectReleases()
    {
        $user = User::factory()->create();
        $releases = Release::factory()->count(10)->create();
        $lastPlayed = $releases->sortBy('last_played')->first();
        $mostPlayed = $releases->sortByDesc('times_played')->take(5)->values()->toArray();
        $this->get(route('home'))
            ->assertSuccessful()
            ->assertSee([$lastPlayed->title, $lastPlayed->artist, $lastPlayed->last_played, $lastPlayed->full_image])
            ->assertSeeInOrder([
                $mostPlayed[0]['full_image'], $mostPlayed[0]['artist'], $mostPlayed[0]['title'], $mostPlayed[0]['times_played'],
                $mostPlayed[1]['full_image'], $mostPlayed[1]['artist'], $mostPlayed[1]['title'], $mostPlayed[1]['times_played'],
                $mostPlayed[2]['full_image'], $mostPlayed[2]['artist'], $mostPlayed[2]['title'], $mostPlayed[2]['times_played'],
                $mostPlayed[3]['full_image'], $mostPlayed[3]['artist'], $mostPlayed[3]['title'], $mostPlayed[3]['times_played'],
                $mostPlayed[4]['full_image'], $mostPlayed[4]['artist'], $mostPlayed[4]['title'], $mostPlayed[4]['times_played']
            ]);
    }
}
