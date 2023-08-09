<?php

namespace Tests\Feature;

use App\Models\Task;
use Facades\Tests\Arrangements\ProjectArrangement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectArrangement::create();
        
        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('project_created', $activity->description);

            $this->assertNull($activity->changes);
        });
    }

     /** @test */
     public function updating_a_project()
     {
        $project = ProjectArrangement::create();
        $originalTitle = $project->title;

        $project->update(['title' => 'new title']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('project_updated', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'new title']
            ];

            $this->assertEquals($expected, $activity->changes);

        });


        $this->assertEquals('project_created', $project->activity->first()->description);
     }

     /** @test */
     public function creating_a_new_task()
     {
        $project = ProjectArrangement::create();

        $project->addTask('test task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('task_created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('test task', $activity->subject->body);
        });

     }

     /** @test */
     public function completing_a_task()
     {
        $project = ProjectArrangement::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'new task', 
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('task_completed', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('new task', $activity->subject->body);
            $this->assertTrue($activity->subject->completed);
        });
     }

     /** @test */
     public function incompleting_a_task()
     {
        $project = ProjectArrangement::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'new task', 
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'new task', 
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('task_not_completed', $project->activity->last()->description);
     }

     /** @test */
     public function deleting_a_task()
     {
        $project = ProjectArrangement::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
     }
}
