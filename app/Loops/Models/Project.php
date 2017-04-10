<?php

namespace Loops\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Loops\Traits\HasNotes;

class Project extends Model
{

    use HasNotes;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loops()
    {
        return $this->hasMany(Loop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
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

    /**
     * Add a user to the project
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users()->attach($user);

        return $this;
    }

    /**
     * Remove a user from the project
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        $this->users()->detach($user);

        return $this;
    }
}
