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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parsed markdown.
     * @return string
     */
    public function getDisplayBodyAttribute()
    {
        $parsedown = new Parsedown();

        return $parsedown->setBreaksEnabled(true)->text($this->attributes['body']);
    }
}
