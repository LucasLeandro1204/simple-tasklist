<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use Illuminate\Http\JsonResponse;
use App\Jobs\CreateTask as Create;
use App\Jobs\DeleteTask as Delete;
use App\Jobs\UpdateTask as Update;
use Illuminate\Database\Eloquent\Collection;

class TaskController extends Controller
{

    /**
     * Return all tasks.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Task::orderBy('id', 'desc')->get();
    }

    /**
     * Return a task.
     *
     * @param Task $task
     * @return Task
     */
    public function show(Task $task): Task
    {
        return $task;
    }

    /**
     * Store a new task.
     *
     * @param StoreTask $request
     * @return JsonResponse
     */
    public function store(StoreTask $request): JsonResponse
    {
        $task = Create::dispatchNow($request->title, $request->description);

        return response()->json($task, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update an existing task.
     *
     * @param UpdateTask $request
     * @param Task $task
     * @return Task
     */
    public function update(UpdateTask $request, Task $task): Task
    {
        return Update::dispatchNow($task, $request->only(['title', 'description', 'status']));
    }

    /**
     * Delete an existing task.
     *
     * @param Task $task
     */
    public function destroy(Task $task): void
    {
        Delete::dispatchNow($task);
    }
}
