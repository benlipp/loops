<?php

namespace Loops\Models;

use App\User;

class Team extends UuidModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('admin')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Add a project to the team.
     *
     * @param Project $project
     *
     * @return $this
     */
    public function addProject(Project $project)
    {
        $project->team()->associate($this);
        $project->save();

        return $this;
    }

    /**
     * Add a user to the team.
     *
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users()->attach($user);

        return $this;
    }

    /**
     * Add an agency to the team.
     * @param \Loops\Models\Agency $agency
     * @return $this
     */
    public function addAgency(Agency $agency)
    {
        $agency->team()->associate($this);
        $agency->save();

        return $this;
    }

    /**
     * Remove a user from the team.
     *
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user)
    {
        $this->users()->detach($user);

        return $this;
    }

    public static function getFromSession()
    {
        $team_id = \Session::get('team_id') ? \Session::get('team_id') : \Auth::user()->teams()->first()->id;

        return self::find($team_id);
    }
}
