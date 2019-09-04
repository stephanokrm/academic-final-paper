<?php

namespace Academic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Session;

/**
 * Class Activity
 * @package Academic
 */
class Activity extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['weight', 'total_score'];

    /**
     * @var array
     */
    protected $with = ['students'];

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot('grade', 'done', 'returned');
    }

    public function scopeByTeam($query, $id)
    {
        /** @var User $user */
        $user = Session::get('user');

        $teamId = $user->isTeacher() ? $id : $user->student()->first()->team_id;

        return $query->where('team_id', $teamId)->get();
    }
}
