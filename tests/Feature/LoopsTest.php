<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Team;
use Loops\Models\Nugget;
use Loops\Models\Project;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoopsTest extends TestCase
{
    use DatabaseMigrations;

    protected $team;
    protected $project;
    protected $loop;

    public function setUp()
    {
        parent::setUp();
        $this->team = factory(Team::class)->create();
        $this->project = factory(Project::class)->make();
        $this->team->addProject($this->project);

        $this->loop = factory(Loop::class)->make();
        $this->project->addLoop($this->loop);
    }

    public function testCreateLoop()
    {
        $loopData = [
            'name' => $this->loop->name,
            'id'   => $this->loop->id,
        ];

        $this->assertDatabaseHas('loops', $loopData);
        $this->assertEquals($this->loop->project->id, $this->project->id);
    }

    public function testAssignTo()
    {
        $user = factory(User::class)->create();
        $this->loop->assignTo($user);
        $this->assertEquals($this->loop->id, $user->loops()->first()->id);

        $assignedLoop = Loop::assignedToUser($user)->first();
        $this->assertEquals($this->loop->id, $assignedLoop->id);
    }

    public function testLoopAddNote()
    {
        $user = factory(User::class)->create();

        $noteObj = factory(Note::class)->make();
        $this->loop->addNote($noteObj, $user);
        $this->assertEquals($noteObj->id, $this->loop->notes()->first()->id);
    }

    public function testOpenClose()
    {
        $this->loop->close();
        $this->assertTrue($this->loop->isClosed());
        $this->assertEquals('Closed', $this->loop->status);
        $this->assertDatabaseHas('loops', [
            'id'     => $this->loop->id,
            'status' => 'closed',
        ]);

        $this->loop->open();
        $this->assertEquals('Open', $this->loop->status);
        $this->assertTrue($this->loop->isOpen());
        $this->assertDatabaseHas('loops', [
            'id'     => $this->loop->id,
            'status' => 'open',
        ]);
    }

    public function testOpenCloseNotes()
    {
        $user = factory(User::class)->create();
        $closeNote = factory(Note::class)->make();
        $this->loop->close($closeNote, $user);
        $this->assertEquals('Closed', $this->loop->status);
        $this->assertTrue($this->loop->isClosed());
        $this->assertTrue($this->loop->notes()->count() == 1);

        $openNote = factory(Note::class)->make();
        $this->loop->open($openNote, $user);
        $this->assertEquals('Open', $this->loop->status);
        $this->assertTrue($this->loop->isOpen());
        $this->assertTrue($this->loop->notes()->count() == 2);
    }

    public function testOpenCloseNoteImpliedUser()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $closeNote = factory(Note::class)->make();
        $this->loop->close($closeNote);
        $this->assertTrue($this->loop->isClosed());
        $this->assertEquals('Closed', $this->loop->status);
        $this->assertTrue($this->loop->notes()->count() == 1);

        $openNote = factory(Note::class)->make();
        $this->loop->open($openNote);
        $this->assertTrue($this->loop->isOpen());
        $this->assertEquals('Open', $this->loop->status);
        $this->assertTrue($this->loop->notes()->count() == 2);
    }

    public function testAddNugget()
    {
        $nuggetData = [
            'name' => 'App URL',
            'data' => 'http://loops.dev',
        ];
        $nugget = new Nugget($nuggetData);
        $this->loop->addNugget($nugget);
        $this->assertDatabaseHas('nuggets', $nuggetData);
        $this->assertTrue($this->loop->nuggets()->count() == 1);
    }
}
