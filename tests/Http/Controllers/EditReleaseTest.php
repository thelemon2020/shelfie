<?php

namespace Tests\Http\Controllers;

use App\Models\Release;
use Tests\TestCase;


class EditReleaseTest extends TestCase
{

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
}
