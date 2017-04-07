<?php

namespace Loops\Models;

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

    public function loops()
    {
        return $this->hasMany(Loop::class);
    }

    public static function openLoops()
    {
        $projects = Project::all();
        return $projects->filter(function($project){
            return $project->hasOpenLoops;
        })->toArray();
    }

    public function getHasOpenLoopsAttribute()
    {
        foreach ($this->loops as $loop)
        {
            if ($loop->status == "Open") return true;
        }
        return false;
    }
}
