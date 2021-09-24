<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use App\Models\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReleaseTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_belongs_to_a_genre()
    {
        $release = Release::factory(['genre_id' => Genre::factory()->create()->id])->create();

        $this->assertInstanceOf(Genre::class, $release->genre);
    }
}
