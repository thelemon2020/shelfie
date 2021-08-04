<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use App\Models\Release;
use Tests\TestCase;

class ReleaseTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_genre()
    {
        $release = Release::factory()->has(Genre::factory(1))->create();

        $this->assertInstanceOf(Genre::class, $release->genre);
    }
}
