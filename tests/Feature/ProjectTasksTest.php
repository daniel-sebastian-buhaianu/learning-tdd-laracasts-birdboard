<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Arrangements\ProjectArrangement;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_add_tasks_to_projects(): void
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks(): void
    {
        $this->signIn();

        $project = Project::factory()->create();
        
        $this->post($project->path() . '/tasks', ['body' => 'new task'])
            ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'new task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_a_task(): void
    {
        $this->signIn();

        $project = ProjectArrangement::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'updated'])
            ->assertForbidden();
        
        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);
    }

    /** @test */
    public function a_project_can_have_tasks(): void
    {
        $project = ProjectArrangement::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated(): void
    {   
        $project = ProjectArrangement::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'updated']);

        $this->assertDatabaseHas('tasks', ['body' => 'updated']);
    }

    /** @test */
    public function a_task_can_be_completed(): void
    {   
        $project = ProjectArrangement::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incomplete(): void
    {   
        $project = ProjectArrangement::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);
        
        $this->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => false
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /** @test */
    public function a_task_requires_a_body(): void
    {
        $project = ProjectArrangement::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }
}
