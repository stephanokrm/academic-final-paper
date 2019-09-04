<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Calendar
 * @package Academic
 */
class Calendar extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['calendar'];

    /**
     * @return BelongsToMany
     */
    public function googles(): BelongsToMany
    {
        return $this->belongsToMany(Google::class);
    }

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function scopeCalendar($query, $calendar)
    {
        return $query->where('calendar', $calendar)->first();
    }

    public function getAttendeesEmails()
    {
        return $this->where('calendars.calendar', '=', $this->calendar)
            ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
            ->join('googles', 'googles.id', '=', 'calendar_google.google_id')
            ->select('googles.email')
            ->get()
            ->lists('email');
    }

    public function exists($id)
    {
        return $this->where('calendar', $id)->exists();
    }

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getAssociatedEmails()
    {
        return $this->where('calendars.calendar', '=', $this->calendar)
            ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
            ->join('googles', 'googles.id', '=', 'calendar_google.google_id')
            ->select('googles.email')
            ->get()
            ->lists('email');
    }

    public static function getCalendarGoogleIdsFromTeams($ids)
    {
        return Calendar::query()
            ->whereIn('team_id', $ids)
            ->select('calendars.calendar')
            ->get()
            ->lists('calendar');
    }

    public static function getCalendarsIdsByGoogleId($id)
    {
        return Calendar::query()
            ->where('calendar_google.google_id', $id)
            ->join('calendar_google', 'calendar_google.calendar_id', '=', 'calendars.id')
            ->get()
            ->lists('calendar');
    }
}
