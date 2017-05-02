<?php

namespace Loops\Models;

use Loops\Traits\HasContacts;

class Agency extends UuidModel
{
    use HasContacts;

    protected $fillable = ['name'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @param \Loops\Models\Project $project
     * @return $this
     */
    public function addProject(Project $project)
    {
        $project->agency()->associate($this);
        $project->save();

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the first (primary) contact.
     *
     * @return mixed
     */
    public function getPrimaryContactAttribute()
    {
        return $this->contacts()->first();
    }
}
