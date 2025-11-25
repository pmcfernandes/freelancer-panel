<?php

namespace App\Jobs;

use App\Models\Note;
use App\Notifications\NoteNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NoteRememberJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Note::where('date', Carbon::today()->addDay())->each(function ($note) {
            $note->user->notify(new NoteNotification($note));
        });

    }
}
