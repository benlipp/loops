<?php

namespace Loops\Traits;

use Loops\Models\Contact;

trait HasContacts
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable')->orderBy('created_at');
    }

    /**
     * Add a contact to the loop.
     *
     * @param Contact $contact
     *
     * @return $this
     */
    public function addContact(Contact $contact)
    {
        $contact->contactable()->associate($this);
        $contact->save();

        return $this;
    }
}
