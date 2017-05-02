<?php

namespace Loops\Models;

use App\User;
use Parsedown;

class Note extends UuidModel
{
    protected $fillable = [
        'body',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayBodyAttribute()
    {
        $parsedown = new Parsedown();

        return $parsedown->text($this->attributes['body']);
    }
}
