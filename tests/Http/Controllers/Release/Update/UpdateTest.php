<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Models\Release;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testItCanReturnSuccess()
    {
        $release = Release::factory()->create();
        $this->getJson(route("api.release.edit", ["id" => $release->id]))
            ->assertSuccessful();
    }
}
