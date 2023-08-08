<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_project(): void
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_it_has_a_path(): void
    {
        $task = Task::factory()->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }
}
