<?php

namespace Loops\Models;

use App\User;
use Loops\Traits\HasNotes;
use Loops\Traits\HasNuggets;
use Loops\Traits\HasContacts;

class Project extends UuidModel
{
    use HasContacts;
    use HasNotes;
    use HasNuggets;

    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loops()
    {
        return $this->hasMany(Loop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * all of Project::query()'s open loops.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOpenLoops($query)
    {
        return $query->whereHas('loops', function ($query) {
            $query->open();
        });
    }

    /**
     * All loops assigned to user.
     *
     * @param $query
     * @param User $user
     *
     * @return mixed
     */
    public function scopeLoopsByUser($query, User $user = null)
    {
        return $query->whereHas('loops', function ($query) use ($user) {
            $query->assignedToUser($user);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Projects by agency.
     *
     * @param $query
     * @param Agency $agency
     *
     * @return mixed
     */
    public function scopeAgency($query, Agency $agency)
    {
        return $query->where('agency_id', $agency->id);
    }

    /**
     * Add a loop to the project.
     *
     * @param Loop $loop
     *
     * @return $this
     */
    public function addLoop(Loop $loop)
    {
        $loop->project()->associate($this);
        $loop->save();

        return $this;
    }

    /**
     * Get the Project description.
     * @return \Loops\Models\Note
     */
    public function getDescriptionAttribute()
    {
        return $this->notes()->first();
    }

    /**
     * Get the Project description.
     * @return \Loops\Models\Note
     */
    public function getLatestNoteAttribute()
    {
        return $this->notes->last();
    }
}
