<?php

namespace Loops\Traits;

use App\User;
use Loops\Models\Note;
use Illuminate\Support\Facades\Auth;

trait HasNotes
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable')->orderBy('updated_at', 'DESC');
    }

    /**
     * Add a note to the loop.
     *
     * @param Note $note
     * @param User $author
     *
     * @return $this
     */
    public function addNote(Note $note, User $author = null)
    {
        $note->author()->associate($author ?? Auth::user());
        $note->notable()->associate($this);
        $note->save();

        return $this;
    }
}
