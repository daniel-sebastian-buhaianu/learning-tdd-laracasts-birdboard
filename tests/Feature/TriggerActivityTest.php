<?php

namespace Tests\Feature;

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
        $this->assertEquals('project_created', $project->activity->first()->description);
    }

     /** @test */
     public function updating_a_project()
     {
         $project = ProjectArrangement::create();

         $project->update(['title' => 'new title']);
         
         $this->assertCount(2, $project->activity);
         $this->assertEquals('project_created', $project->activity->first()->description);
         $this->assertEquals('project_updated', $project->activity->last()->description);
     }

     /** @test */
     public function creating_a_new_task()
     {
        $project = ProjectArrangement::create();

        $project->addTask('test task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('task_created', $project->activity->last()->description);
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
        $this->assertEquals('task_completed', $project->activity->last()->description);
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
