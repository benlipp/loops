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
}
