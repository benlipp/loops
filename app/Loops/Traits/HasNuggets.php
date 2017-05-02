<?php

namespace Loops\Traits;

use Loops\Models\Nugget;

trait HasNuggets
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function nuggets()
    {
        return $this->morphMany(Nugget::class, 'nuggetable')->orderBy('sort_order')->orderBy('created_at', 'asc');
    }

    /**
     * @param Nugget $nugget
     *
     * @return $this
     */
    public function addNugget(Nugget $nugget)
    {
        $nugget->nuggetable()->associate($this);
        $nugget->save();

        return $this;
    }
}
