<?php

namespace Tests\Feature\Models;

use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_many_releases()
    {
        $user = User::factory()->has(Release::factory(2))->create();

        $this->assertInstanceOf(Release::class, $user->releases->first());
        $this->assertCount(2, $user->releases);
    }
}
