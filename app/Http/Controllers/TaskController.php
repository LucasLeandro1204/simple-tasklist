<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Jobs\CreateTask as Create;
use App\Jobs\DeleteTask as Delete;
use App\Jobs\UpdateTask as Update;
use Illuminate\Database\Eloquent\Collection;

class TaskController extends Controller
{
    /**
     * Return all tasks.
     */
    public function index(): Collection
    {
        return Task::orderBy('id', 'desc')->get();
    }

    /**
     * Return a task.
     */
    public function show(Task $task): Task
    {
        return $task;
    }

    /**
     * Store a new task.
     */
    public function store(Request $request): JsonResponse
    {
        $data = array_values($request->validate([
            'title' => 'required|string|max:80',
            'description' => 'nullable|string|max:2000',
        ]));

        $task = Create::dispatchNow(...$data);

        return response()->json($task, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a task.
     */
    public function update(Request $request, Task $task): Task
    {
        $data = $request->validate([
            'title' => 'string|max:80',
            'description' => 'nullable|string|max:2000',
            'status' => 'boolean',
        ]);

        return Update::dispatchNow($task, $data);
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task): void
    {
        Delete::dispatchNow($task);
    }
}
