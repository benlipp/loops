<?php

namespace Tests\Feature;

use Loops\Models\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @dataProvider contactDataProvider
     * @param $contactData
     */
    public function testCreateContact($contactData)
    {

        $project = factory(\Loops\Models\Project::class)->create();
        $contact = new Contact($contactData);
        $contact->project()->associate($project)->save();
        $this->assertDatabaseHas('contacts', $contactData);
    }

    public function contactDataProvider()
    {
        return [
            [
                [
                    'name'    => 'Test Dude',
                    'company' => 'Test Company',
                    'email'   => 'test@test.dev',
                    'phone'   => '123-456-7890'
                ]
            ],
            [
                [
                    'name'    => 'Limited Info',
                    'company' => null,
                    'email'   => null,
                    'phone'   => null
                ]
            ]
        ];
    }
}
