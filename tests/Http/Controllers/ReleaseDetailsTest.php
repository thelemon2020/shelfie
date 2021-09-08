<?php

namespace Tests\Http\Controllers;

use App\Models\Release;
use Tests\TestCase;


class ReleaseDetailsTest extends TestCase
{

    public function testItCanReturnSuccess()
    {
        $release = Release::factory()->create();
        $this->get(route('release.show', ['id' => $release->id]))
            ->assertSuccessful();
    }

    public function testItReturnsAView()
    {
        $release = Release::factory()->create();
        $this->get(route('release.show', ['id' => $release->id]))
            ->assertViewIs('releaseDetails');
    }

    public function testItGeneratesTheBladeProperly()
    {
        $release = Release::factory()->create();
        $this->get(route('release.show', ['id' => $release->id]))
            ->assertViewIs('releaseDetails')
            ->assertSeeInOrder([$release->artist, $release->title, $release->thumbnail, $release->times_played, $release->last_played_at]);
    }
}
