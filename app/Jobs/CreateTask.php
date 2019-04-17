<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateTask
{
    use Dispatchable;

    /**
     * The new task title.
     *
     * @var string
     */
    protected $title;

    /**
     * The new task description.
     *
     * @var string
     */
    protected $description;

    /**
     * The new task status.
     *
     * @var bool
     */
    protected $status;

    /**
     * Create a new job instance.
     */
    public function __construct(string $title, string $description = null, bool $status = false)
    {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): Task
    {
        return Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
        ]);
    }
}
