<?php

namespace Tests\Feature;

use App\User;
use Loops\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsTest extends TestCase
{

    use DatabaseMigrations;

    public function testCreatesProjects()
    {
        $projectData = [
            'name' => 'TestProject'
        ];
        $project = Project::create($projectData);
        $this->assertEquals($projectData['name'], $project->name);
        $this->assertDatabaseHas('projects', $projectData);
    }

    public function testAddRemoveUserProjects()
    {
        $projects = factory(Project::class, 3)->create();
        $user = factory(User::class)->create();
        foreach ($projects as $project)
        {
            $project->addUser($user);
            $this->assertTrue($project->users()->count() == 1);
        }
        $this->assertTrue($user->projects()->count() == 3);

        foreach ($projects as $project)
        {
            $project->removeUser($user);
        }
        $this->assertTrue($user->projects()->count() == 0);
    }
}
