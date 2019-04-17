<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateTask
{
    use Dispatchable;

    /**
     * The task.
     *
     * @var Task
     */
    protected $task;

    /**
     * The attributes to update.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     * @param array $attributes
     */
    public function __construct(Task $task, array $attributes)
    {
        $this->task = $task;
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): Task
    {
        $this->task->update($this->attributes);

        return tap($this->task)->save();
    }
}
