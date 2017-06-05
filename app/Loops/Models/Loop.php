<?php

namespace Loops\Models;

use App\User;
use Loops\Traits\HasNotes;
use Loops\Traits\HasNuggets;

class Loop extends UuidModel
{
    use HasNotes;
    use HasNuggets;

    protected $fillable = [
        'name',
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
     * Assign the loop to a User.
     *
     * @param User $user
     *
     * @return $this
     */
    public function assignTo(User $user = null)
    {
        $this->user()->dissociate()->save();
        if ($user) {
            $this->user()->associate($user)->save();
        }

        return $this;
    }

    /**
     * Scope by Status.
     *
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    /**
     * Scope to Open Loops.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOpen($query)
    {
        return $query->status('open');
    }

    /**
     * Scope to Closed Loops.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeClosed($query)
    {
        return $query->status('closed');
    }

    public function scopeAssignedToUser($query, User $user = null)
    {
        return $query->where('user_id', $user->id ? $user->id : null);
    }

    /**
     * Open the loop - with optional note.
     *
     * @param Note|null $note
     * @param User|null $author
     *
     * @return $this
     */
    public function open(Note $note = null, User $author = null)
    {
        if (isset($note)) {
            $this->addNote($note, $author);
        }

        $this->status = 'open';
        $this->save();

        return $this;
    }

    /**
     * Close the loop - with optional Note.
     *
     * @param Note|null $note
     * @param User|null $author
     *
     * @return $this
     */
    public function close(Note $note = null, User $author = null)
    {
        if (isset($note)) {
            $this->addNote($note, $author);
        }

        $this->status = 'closed';
        $this->save();

        return $this;
    }

    /**
     * Get the formatted status.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return ucfirst($this->attributes['status']);
    }

    /**
     * Get the user who opened the note.
     *
     * @return mixed
     */
    public function getOpenedByAttribute()
    {
        $firstNote = $this->notes()->orderBy('created_at', 'asc')->first();

        return $firstNote->author;
    }

    /**
     * Get the user who opened the note.
     *
     * @return mixed
     */
    public function getNewestNoteAttribute()
    {
        $firstNote = $this->notes()->orderBy('created_at', 'desc')->first();

        return $firstNote;
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return $this->attributes['status'] === 'open';
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->attributes['status'] === 'closed';
    }
}
