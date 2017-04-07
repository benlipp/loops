<?php

namespace Tests\Feature;

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
    }
}
