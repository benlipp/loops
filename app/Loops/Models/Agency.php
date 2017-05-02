<?php

namespace App\Loops\Models;

use Loops\Models\Project;
use Loops\Models\Team;
use Loops\Models\UuidModel;
use Loops\Traits\HasContacts;

class Agency extends UuidModel
{
    use HasContacts;

    protected $fillable = ['name'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

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
