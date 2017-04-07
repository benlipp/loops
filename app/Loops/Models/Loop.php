<?php

namespace Loops\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Loops\Traits\HasNotes;

class Loop extends Model
{
    use HasNotes;

    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignTo($user = null)
    {
        $this->user()->associate($user)->save();
        return $this;
    }

    public function latestNote()
    {
        return $this->notes()->orderBy('updated_at', 'DESC')->first();
    }

    public function getStatusAttribute()
    {
        return $this->latestNote()->status;
    }


}
