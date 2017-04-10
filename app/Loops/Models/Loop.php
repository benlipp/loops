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

    /**
     * Add a note to the loop
     * @param Note|array $note
     * @param User $author
     * @return $this
     */
    public function addNote(Note $note, User $author)
    {
        $note->author()->associate($author);
        $note->notable()->associate($this);
        $note->save();

        return $this;
    }

    /**
     * Assign the loop to a User
     * @param User $user
     * @return $this
     */
    public function assignTo(User $user)
    {
        $this->user()->associate($user)->save();
        return $this;
    }

    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function scopeOpen($query)
    {
        return $query->status('open');
    }

    public function scopeClosed($query)
    {
        return $query->status('closed');
    }


}
