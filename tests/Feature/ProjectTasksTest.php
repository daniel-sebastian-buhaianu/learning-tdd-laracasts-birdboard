<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks_to_projects(): void
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function test_only_the_owner_of_a_project_can_add_tasks(): void
    {
        $this->signIn();

        $project = Project::factory()->create();
        
        $this->post($project->path() . '/tasks', ['body' => 'new task'])
            ->assertForbidden();

        $this->assertDatabaseMissing('tasks', ['body' => 'new task']);
    }

    public function test_only_the_owner_of_a_project_can_update_a_task(): void
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('test task');
        
        $this->patch($task->path(), ['body' => 'updated'])
            ->assertForbidden();
        
        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);
    }

    public function test_project_can_have_tasks(): void
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_task_can_be_updated(): void
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask('a new task');

        $this->patch($task->path(), [
            'body' => 'a new task, updated',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'a new task, updated',
            'completed' => true
        ]);
    }

    public function test_task_requires_a_body(): void
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
