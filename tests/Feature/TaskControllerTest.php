<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_tasks(): void
    {
        factory(Task::class, 15)->create();

        $response = $this->json('GET', route('task.index'));

        $response->assertStatus(200);

        $this->assertCount(15, $response->decodeResponseJson());
    }

    /** @test */
    public function can_list_a_task(): void
    {
        $task = factory(Task::class)->create();

        $response = $this->json('GET', route('task.show', 1337));
        $response->assertStatus(404);

        $response = $this->json('GET', route('task.show', $task));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'created_at', 'updated_at',
            ]);
    }

    /** @test */
    public function can_create_a_task(): void
    {
        $this->assertCount(0, Task::get());

        $response = $this->json('POST', route('task.store'), [
            //
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
            ]);

        $response = $this->json('POST', route('task.store'), [
            'title' => str_pad('', 100, '-'),
            'description' => str_pad('', 2048, '-'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title', 'description',
            ]);

        $response = $this->json('POST', route('task.store'), [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $json = $response->decodeResponseJson();

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'created_at', 'updated_at',
            ])
            ->assertJsonFragment([
                'title' => 'Title',
                'description' => 'Description',
                'status' => false,
            ]);

        $this->assertNotNull($task = Task::first());

        $this->assertEquals($task->id, $json['id']);
        $this->assertEquals($task->title, $json['title']);
        $this->assertEquals($task->description, $json['description']);

        $task->delete();

        $response = $this->json('POST', route('task.store'), [
            'title' => 'Title',
        ]);

        $json = $response->decodeResponseJson();

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'created_at', 'updated_at',
            ])
            ->assertJsonFragment([
                'title' => 'Title',
                'status' => false,
            ]);

        $this->assertNotNull($task = Task::first());
        $this->assertNull($task->description);
    }

    /** @test */
    public function can_update_a_task(): void
    {
        $task = factory(Task::class)->create();

        $response = $this->json('PUT', route('task.update', [
            'task' => 1337,
        ]));
        $response->assertStatus(404);

        $response = $this->json('PUT', route('task.update', $task), [
            'title' => str_pad('', 100, '-'),
            'description' => str_pad('', 2048, '-'),
            'status' => '131',
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title', 'description', 'status',
            ]);

        $response = $this->json('PUT', route('task.update', $task), [
            'title' => 'New Title',
            'description' => 'New Description',
            'status' => true,
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'title', 'description', 'status', 'created_at', 'updated_at',
            ])
            ->assertJsonFragment([
                'title' => 'New Title',
                'description' => 'New Description',
                'status' => true,
            ]);

        $json = $response->decodeResponseJson();

        $task = $task->fresh();

        $this->assertEquals($task->id, $json['id']);
        $this->assertEquals($task->title, $json['title']);
        $this->assertEquals($task->description, $json['description']);
    }

    /** @test */
    public function can_delete_a_task(): void
    {
        $task = factory(Task::class)->create();

        $response = $this->json('DELETE', route('task.delete', [
            'task' => 1337,
        ]));
        $response->assertStatus(404);

        $this->json('DELETE', route('task.delete', $task));

        $this->assertFalse(Task::exists($task->id));
    }
}
