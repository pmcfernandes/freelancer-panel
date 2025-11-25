<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Components\Timezone;

class NoteController extends Controller
{
    public function calendar() : Response
    {
        $calendar = Calendar::create()
            ->timezone(Timezone::create('Europe/Lisbon'))
            ->name('Meetings Calendar')
            ->description('Calendar for meetings')
            ->refreshInterval(60);

        Note::all()->each(function ($note) use ($calendar) {
            $date = Carbon::parse($note->date);
            $dateMoreHour = $date->copy()->addHour();
            $dateLessHour = $date->copy()->subHour();

            $event = Event::create($note->title)
                ->uniqueIdentifier($note->id)
                ->description($note->content)
                ->startsAt($date)
                ->endsAt($dateMoreHour)
                ->createdAt($note->created_at)
                ->alertAt($dateLessHour, "You have a meeting: {$note->title} in 1 hour.");
            $calendar->event($event);
        });

        return response($calendar->get(), 200, [
            'Content-Type', 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="meets.ics"',
        ]);
    }
}
