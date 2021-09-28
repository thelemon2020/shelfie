<?php

namespace Tests\Http\Controllers;

use App\Models\Release;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class EditReleaseTest extends TestCase
{
    use RefreshDatabase;
    public function testItReturnsSuccess()
    {
        $release = Release::factory()->create();
        $this->get(route("release.edit.show", ['id' => $release->id]))
            ->assertSuccessful();
    }

    public function testItReturnsTheCorrectView()
    {
        $release = Release::factory()->create();
        $this->get(route("release.edit.show", ['id' => $release->id]))
            ->assertViewIs('editRelease');
    }

    public function testTheBladeHasTheCorrectData()
    {
        $this->withoutExceptionHandling();
        $release = Release::factory()->create([
            'shelf_order' => 5,
        ]);

        $this->get(route("release.edit.show", ['id' => $release->id]))
            ->assertViewIs('editRelease')
            ->assertSeeInOrder([
                $release->artist,
                $release->title,
                $release->shelf_order
            ]);
    }
}
