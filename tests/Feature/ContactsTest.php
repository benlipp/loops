<?php

namespace Tests\Feature;

use Loops\Models\Contact;
use Loops\Models\Project;
use Loops\Models\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ContactsTest extends TestCase
{

    use DatabaseMigrations;

    protected $team;
    protected $project;

    public function setUp()
    {
        parent::setUp();
        $this->team = factory(Team::class)->create();
        $this->project = factory(Project::class)->make();
        $this->team->addProject($this->project);
        $this->contact = factory(Contact::class)->create();
    }

    /**
     * @skip
     */
    public function testCreateContact()
    {

    }

}
