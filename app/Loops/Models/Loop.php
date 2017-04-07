<?php

namespace Loops\Models;

use Illuminate\Database\Eloquent\Model;

class Loop extends Model
{

    protected $fillable = [
        'name',
        'assigned_user_id'
    ];
}
