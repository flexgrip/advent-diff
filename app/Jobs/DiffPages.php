<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class DiffPages extends Job
{
    protected $url;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info($this->url);
    }
}