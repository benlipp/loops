<?php

namespace Loops\Models;

use App\User;
use Loops\Traits\HasContacts;
use Loops\Traits\HasNotes;
use Loops\Traits\HasNuggets;

class Project extends UuidModel
{

    use HasContacts;
    use HasNotes;
    use HasNuggets;

    protected $fillable = [
        'name'
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
     * all of Project::query()'s open loops
     * @param $query
     * @return mixed
     */
    public function scopeOpenLoops($query)
    {
        return $query->whereHas('loops', function ($query) {
            $query->open();
        });
    }

    /**
     * All loops assigned to user
     * @param $query
     * @param null $user_id
     * @return mixed
     */
    public function scopeLoopsByUser($query, $user_id = null)
    {
        return $query->whereHas('loops', function ($query) use ($user_id) {
            $query->assignedToUser($user_id);
        });
    }

    /**
     * Add a loop to the project
     * @param Loop $loop
     * @return $this
     */
    public function addLoop(Loop $loop)
    {
        $loop->project()->associate($this);
        $loop->save();

        return $this;
    }


}
