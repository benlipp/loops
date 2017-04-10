<?php

namespace Loops\Traits;

use Loops\Models\Note;

trait HasNotes
{

    /**
     * @return @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable')->orderBy('updated_at', 'DESC');
    }

}