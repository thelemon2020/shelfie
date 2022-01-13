<?php

namespace Tests\Http\Controllers;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionManageTest extends TestCase
{
    use RefreshDatabase;

    public function testItReturnsAView()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('collection.manage.index'));
        $response->assertStatus(200)
            ->assertViewIs('manageCollection');
    }

    public function testItReturnsACollectionOfGenres()
    {
        $user = User::factory()->create();
        $genres = collect(Genre::factory(5)->create([
            'user_id' => $user->id,
        ]))->pluck('name');

        $response = $this->actingAs($user)->get(route('collection.manage.index'));
        foreach ($genres as $genre) {
            $response->assertSee($genre);
        }
    }

    public function testItReturnsACollectionOfGenresInOrder()
    {
        $user = User::factory()->create();
        $genres = collect(Genre::factory(5)->create([
            'user_id' => $user->id,
        ]))->sortBy('shelf_order')->pluck('name');
        $this->actingAs($user)->get(route('collection.manage.index'))->assertSeeInOrder($genres->toArray());
    }

    public function testGenreShelfOrderCanBeChanged()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $genres = collect(Genre::factory(5)->create([
            'user_id' => $user->id,
        ]))->sortBy('shelf_order');
        $i = count($genres);
        foreach ($genres as $genre) {
            $genre->shelf_order = $i;
            $i--;
        }
        $genreNames = $genres->sortBy('shelf_order')->pluck('name');
        $this->actingAs($user)->get(route('collection.manage.index'))->assertSeeInOrder($genreNames->toArray());
    }
}
