<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Project;
use Loops\Models\Team;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{

    use Notifiable;

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'author_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class)->withPivot('admin')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loops()
    {
        return $this->hasMany(Loop::class);
    }

    /**
     * @param null $team_id
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function projectsByTeam($team_id)
    {
        $team = $this->teams()->where('team_id', $team_id)->first();
        return $team->projects();
    }

}
