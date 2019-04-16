<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteTask
{
    use Dispatchable;

    /**
     * The task to be deleted.
     *
     * @var Task
     */
    protected $task;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->task->delete();
    }
}
