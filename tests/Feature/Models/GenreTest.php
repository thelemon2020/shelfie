<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_belongs_to_a_user()
    {
        $genre = Genre::factory()->has(User::factory(1))->create();

        $this->assertInstanceOf(User::class, $genre->user);
    }
}
