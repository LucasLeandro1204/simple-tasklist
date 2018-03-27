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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Execute the job.
     */
    public function handle(): Task
    {
        return Task::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }
}
