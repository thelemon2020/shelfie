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
}
