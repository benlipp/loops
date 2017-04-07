<?php

namespace Loops\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    protected $fillable = [
        'body',
        'action',
        'status'
    ];
}
