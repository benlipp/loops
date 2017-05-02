<?php

namespace Tests\Feature;

use Loops\Models\Agency;
use Loops\Models\Contact;
use Loops\Models\Project;
use Loops\Models\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AgenciesTest extends TestCase
{

    use DatabaseMigrations;

    protected $team;
    protected $project;
    protected $contact;
    protected $agency;

    public function setUp()
    {
        parent::setUp();
        $this->team = factory(Team::class)->create();
        $this->project = factory(Project::class)->make();
        $this->team->addProject($this->project);
        $this->contact = factory(Contact::class)->create();
        $this->agency = factory(Agency::class)->make();
        $this->team->addAgency($this->agency);
    }

    public function testCreatesAgencies()
    {
        $agencyData = [
            'name' => 'Some Test Agency',
        ];

        $agency = new Agency($agencyData);
        $this->team->addAgency($agency);

        $this->assertDatabaseHas('agencies', $agencyData);
        $this->assertEquals($this->team->id, $agency->team->id);
    }

    public function testProjectAgency()
    {
        $this->agency->addProject($this->project);

        $project = $this->project->toArray();
        unset($project['team']);
        unset($project['agency']);

        $this->assertDatabaseHas('projects', $project);
        $this->assertEquals($this->project->agency->id, $this->agency->id);
    }

    public function testAgencyContact()
    {
        $this->agency->addContact($this->contact);
        $this->assertEquals($this->agency->contacts()->first()->id, $this->contact->id);
        $this->assertEquals($this->agency->primaryContact->id, $this->agency->contacts()->first()->id);
        $newContact = factory(Contact::class)->create();
        $this->agency->addContact($newContact);
        $this->assertNotEquals($newContact->id, $this->agency->primaryContact->id);
    }


}
