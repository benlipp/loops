<?php

namespace Tests\Feature;

use App\User;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoopsTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @dataProvider loopData
     */
    public function testCreateLoop($loopData)
    {
        $project = factory(Project::class)->create();
        $loop = new Loop($loopData);
        $loop->project()->associate($project)->save();

        $this->assertDatabaseHas('loops', $loopData);
        $this->assertEquals($loop->project->id, $project->id);
    }

    public function testAssignTo()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();
        $loop->project()->associate($project)->save();
        $loop->assignTo($user);
        $this->assertEquals($loop->id, $user->loops()->first()->id);
    }

    /**
     * @dataProvider notesData
     */
    public function testNotes($noteData)
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();

        $this->actingAs($user);

        $loop = factory(Loop::class)->make();
        $loop->project()->associate($project)->save();
        $loop->assignTo($user);

        $note = new Note($noteData);
        $note->notable()->associate($loop);
        $note->author()->associate($user)->save();

        $this->assertDatabaseHas('notes', $noteData);
        // make sure our status is the status of our most recent note
        $this->assertEquals($note->status, $loop->status);
    }

    public function testUserProjectOpenLoops()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
    }

    public function loopData()
    {
        return [
            [
                [
                    'name' => 'Open Loop Test'
                ]
            ],
            [
                [
                    'name' => 'Testing 123'
                ]
            ]
        ];
    }

    public function notesData()
    {
        return [
            [
                [
                    'body'   => '_test_ **markdown** document',
                    'action' => 'opened',
                    'status' => 'Open'
                ]
            ],
            [
                [
                    'body'   => '_test_ **markdown** document',
                    'action' => 'closed',
                    'status' => 'Close'
                ]
            ],
        ];
    }

}
