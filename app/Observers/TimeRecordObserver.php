<?php

namespace App\Observers;

use App\Models\TimeRecord;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class TimeRecordObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the TimeRecord "created" event.
     */
    public function created(TimeRecord $timeRecord): void
    {
        TimeRecord::find($timeRecord->id)->update([
            'revenue' => $timeRecord->project->hourly_rate * $timeRecord->hours
        ]);
    }

    /**
     * Handle the TimeRecord "updated" event.
     */
    public function updated(TimeRecord $timeRecord): void
    {
        TimeRecord::find($timeRecord->id)->update([
            'revenue' => $timeRecord->project->hourly_rate * $timeRecord->hours
        ]);
    }

    /**
     * Handle the TimeRecord "deleted" event.
     */
    public function deleted(TimeRecord $timeRecord): void
    {
        //
    }

    /**
     * Handle the TimeRecord "restored" event.
     */
    public function restored(TimeRecord $timeRecord): void
    {
        //
    }

    /**
     * Handle the TimeRecord "force deleted" event.
     */
    public function forceDeleted(TimeRecord $timeRecord): void
    {
        //
    }
}
