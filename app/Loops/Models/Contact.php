<?php

namespace Loops\Models;

use Illuminate\Database\Eloquent\Model;
use Loops\Traits\HasNotes;

class Contact extends Model
{

    use HasNotes;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'primary'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
