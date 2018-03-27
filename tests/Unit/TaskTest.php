<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;
use App\Jobs\CreateTask as Create;
use App\Jobs\UpdateTask as Update;
use App\Jobs\DeleteTask as Delete;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function we_can_create_a_task(): void
    {
        $this->assertCount(0, Task::get());

        $response = (new Create('Title', 'Description'))->handle();

        $this->assertInstanceOf(Task::class, $response);

        $this->assertNotNull($task = Task::first());
        $this->assertEquals('Title', $task->title);
        $this->assertEquals('Description', $task->description);
        $this->assertFalse($task->status);
    }

    /** @test */
    public function we_can_update_a_task(): void
    {
        $task = factory(Task::class)->create();

        $response = (new Update($task, [
            'title' => 'Title',
            'description' => 'Description',
            'status' => true,
        ]))->handle();

        $this->assertInstanceOf(Task::class, $response);

        $task = $task->fresh();

        $this->assertEquals('Title', $task->title);
        $this->assertEquals('Description', $task->description);
        $this->assertTrue($task->status);
    }

    /** @test */
    public function we_can_delete_a_task(): void
    {
        $task = factory(Task::class)->create();

        (new Delete($task))->handle();

        $this->assertFalse(Task::exists($task->id));
    }
}
