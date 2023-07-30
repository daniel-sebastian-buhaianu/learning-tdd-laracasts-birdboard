<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_only_authenticated_users_can_create_projects(): void
    {
        $attributes = Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    public function test_user_can_create_a_project(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $attributes = Project::factory()->raw(['owner_id' => $user->id]);

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_user_can_view_a_project(): void
    {
        $project = Project::factory()->create();

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_project_requires_a_title(): void
    {
        $this->actingAs(User::factory()->create());
        
        $attributes = Project::factory()->raw(['title' => '']);
        
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_project_requires_a_description(): void
    {
        $this->actingAs(User::factory()->create());

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}