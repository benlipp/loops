<?php

namespace Loops\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class UuidModel extends Model
{
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }
}
