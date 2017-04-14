<?php

namespace Loops\Traits;

use App\User;
use Illuminate\Support\Facades\Auth;
use Loops\Models\Contact;
use Loops\Models\Note;

trait HasContacts
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * Add a contact to the loop
     * @param Contact $contact
     * @return $this
     */
    public function addContact(Contact $contact)
    {
        $contact->contactable()->associate($this);
        $contact->save();

        return $this;
    }

}