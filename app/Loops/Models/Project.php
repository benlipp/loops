<?php

namespace Loops\Models;

use App\User;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loops()
    {
        return $this->hasMany(Loop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        //'project_users', 'user_id', 'project_id'
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users()->attach($user);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        if ($user){
            $this->users()->detach($user);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasOpenLoopsAttribute()
    {
        foreach ($this->loops as $loop)
        {
            if ($loop->status == "Open") return true;
        }
        return false;
    }
}
