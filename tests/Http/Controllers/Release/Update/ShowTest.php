<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Models\Release;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function testItCanReturnSuccess()
    {
        $release = Release::factory()->create();
        $this->get(route("release.edit.show", ["id" => $release->id]))
            ->assertSuccessful();
    }

    public function testItReturnsTheCorrectView()
    {
        $release = Release::factory()->create();
        $this->get(route("release.edit.show", ["id" => $release->id]))
            ->assertViewIs('editRelease');
    }

    public function testItLoadsTheCorrectRelease()
    {
        $release = Release::factory()->create();
        $this->get(route("release.edit.show", ["id" => $release->id]))
            ->assertSeeInOrder([
                $release->artist,
                $release->title,
                $release->shelf_order
            ]);
    }
}
