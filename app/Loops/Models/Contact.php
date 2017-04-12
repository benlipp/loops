<?php

namespace Loops\Models;

use Loops\Traits\HasNotes;

class Contact extends UuidModel
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
