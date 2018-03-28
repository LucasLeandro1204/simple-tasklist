<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use App\Jobs\CreateTask as Create;
use App\Jobs\DeleteTask as Delete;
use App\Jobs\UpdateTask as Update;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_create_a_task(): void
    {
        $this->assertCount(0, Task::get());

        $response = Create::dispatchNow('Title', 'Description');

        $this->assertInstanceOf(Task::class, $response);

        $this->assertNotNull($task = Task::first());

        $this->assertEquals($task->id, $response->id);
        $this->assertEquals('Title', $task->title);
        $this->assertEquals('Description', $task->description);
        $this->assertFalse($task->status);
    }

    /** @test */
    public function we_can_update_a_task(): void
    {
        $task = factory(Task::class)->create();

        $response = Update::dispatchNow($task, [
            'title' => 'Title',
            'description' => 'Description',
            'status' => true,
        ]);

        $this->assertInstanceOf(Task::class, $response);
        $this->assertEquals($task->id, $response->id);

        $task = $task->fresh();

        $this->assertEquals('Title', $task->title);
        $this->assertEquals('Description', $task->description);
        $this->assertTrue($task->status);
    }

    /** @test */
    public function we_can_delete_a_task(): void
    {
        $task = factory(Task::class)->create();

        Delete::dispatchNow($task);

        $this->assertFalse(Task::exists($task->id));
    }
}
