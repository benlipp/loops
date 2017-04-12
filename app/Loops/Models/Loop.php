<?php

namespace Loops\Models;

use App\User;
use Illuminate\Support\Facades\Auth;
use Loops\Traits\HasNotes;

class Loop extends UuidModel
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
    public function addNote(Note $note, User $author = null)
    {
        $note->author()->associate($author ?? Auth::user());
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

    /**
     * Scope by Status
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    /**
     * Scope to Open Loops
     * @param $query
     * @return mixed
     */
    public function scopeOpen($query)
    {
        return $query->status('open');
    }

    /**
     * Scope to Closed Loops
     * @param $query
     * @return mixed
     */
    public function scopeClosed($query)
    {
        return $query->status('closed');
    }


    /**
     * Open the loop - with optional note
     * @param Note|null $note
     * @param User|null $author
     * @return $this
     */
    public function open(Note $note = null, User $author = null)
    {
        if (isset($note))
        {
            $this->addNote($note, $author);
        }

        $this->status = 'open';
        $this->save();

        return $this;
    }

    /**
     * Close the loop - with optional Note
     * @param Note|null $note
     * @param User|null $author
     * @return $this
     */
    public function close(Note $note = null, User $author = null)
    {
        if (isset($note))
        {
            $this->addNote($note, $author);
        }

        $this->status = 'closed';
        $this->save();

        return $this;
    }

    /**
     * Get the formatted status
     * @return string
     */
    public function getStatusAttribute()
    {
        return ucfirst($this->attributes['status']);
    }

    /**
     * Get the user who opened the note
     * @return mixed
     */
    public function getOpenedByAttribute()
    {
        $firstNote = $this->notes()->orderBy('created_at', 'asc')->first();
        return $firstNote->author;
    }

}
