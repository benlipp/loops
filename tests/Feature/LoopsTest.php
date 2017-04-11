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

    public function testCreateLoop()
    {
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();

        $project->addLoop($loop);

        $loopData = [
            'name' => $loop->name,
            'id' => $loop->id
        ];

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

    public function testLoopAddNote()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();

        $project->addLoop($loop)->addUser($user);
        $noteObj = factory(Note::class)->make();
        $loop->addNote($noteObj, $user);
        $this->assertEquals($noteObj->id, $loop->notes()->first()->id);
    }

    public function testOpenClose()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();
        $project->addLoop($loop)->addUser($user);
        $this->assertDatabaseHas('loops', [
            'id' => $loop->id,
            'status' => 'open'
        ]);
        $loop->close();
        $this->assertEquals('Closed', $loop->status);
        $this->assertDatabaseHas('loops', [
            'id' => $loop->id,
            'status' => 'closed'
        ]);

        $loop->open();
        $this->assertEquals('Open', $loop->status);
        $this->assertDatabaseHas('loops', [
            'id' => $loop->id,
            'status' => 'open'
        ]);
    }

    public function testOpenCloseNotes()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();
        $project->addLoop($loop)->addUser($user);
        $this->assertDatabaseHas('loops', [
            'id' => $loop->id,
            'status' => 'open'
        ]);

        $closeNote = factory(Note::class)->make();
        $loop->close($closeNote, $user);
        $this->assertEquals('Closed', $loop->status);
        $this->assertTrue($loop->notes()->count() == 1);

        $openNote = factory(Note::class)->make();
        $loop->open($openNote, $user);
        $this->assertEquals('Open', $loop->status);
        $this->assertTrue($loop->notes()->count() == 2);
    }

    public function testOpenCloseNoteImpliedUser()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        $loop = factory(Loop::class)->make();
        $project->addLoop($loop)->addUser($user);
        $this->assertDatabaseHas('loops', [
            'id' => $loop->id,
            'status' => 'open'
        ]);

        $this->actingAs($user);

        $closeNote = factory(Note::class)->make();
        $loop->close($closeNote);
        $this->assertEquals('Closed', $loop->status);
        $this->assertTrue($loop->notes()->count() == 1);

        $openNote = factory(Note::class)->make();
        $loop->open($openNote);
        $this->assertEquals('Open', $loop->status);
        $this->assertTrue($loop->notes()->count() == 2);
    }

}
