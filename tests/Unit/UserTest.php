<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_has_projects(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
