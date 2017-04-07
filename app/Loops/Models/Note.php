<?php

namespace Loops\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    protected $fillable = [
        'body',
        'action',
        'status'
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
}
