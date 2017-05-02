<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Loops\Models\Team;
use Loops\Models\Nugget;
use Loops\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectsTest extends TestCase
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
    }

    public function testCreatesProjects()
    {
        $projectData = [
            'name' => 'TestProject',
        ];

        $project = new Project($projectData);
        $this->team->addProject($project);

        $this->assertEquals($projectData['name'], $project->name);
        $this->assertDatabaseHas('projects', $projectData);
    }

    public function testUserProjects()
    {
        $user = factory(User::class)->create();
        $this->team->addUser($user);
        $this->assertTrue($user->projectsByTeam($this->team->id)->first()->id == $this->project->id);
    }

    public function testAddNugget()
    {
        $nuggetData = [
            'name' => 'App URL',
            'data' => 'http://loops.dev',
        ];
        $nugget = new Nugget($nuggetData);
        $this->project->addNugget($nugget);
        $this->assertDatabaseHas('nuggets', $nuggetData);
        $this->assertTrue($this->project->nuggets()->count() == 1);
    }
}
