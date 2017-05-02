<?php

namespace Loops\Models;

class Nugget extends UuidModel
{
    protected $fillable = [
        'name',
        'data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function nuggetable()
    {
        return $this->morphTo();
    }
}
