<?php

namespace Tests\Http\Controllers\Release\Update;

use App\Models\Release;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    public function testItCanReturnASuccess()
    {
        $release = Release::factory()->create();
        $this->post(route('api.release.edit', $release->id))->assertSuccessful();
    }

    public function testItCanUpdateARelease()
    {
        $release = Release::factory()->create();
    }
}
