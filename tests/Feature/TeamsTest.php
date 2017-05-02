<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Loops\Models\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TeamsTest extends TestCase
{
    use DatabaseMigrations;

    protected $team;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->team = factory(Team::class)->create();
        $this->user = factory(User::class)->create();
        $this->team->addUser($this->user);
    }

    public function testAddRemoveUser()
    {
        $assoc_data = [
            'team_id' => $this->team->id,
            'user_id' => $this->user->id,
        ];

        // user added in setup function
        $this->assertTrue($this->team->users()->count() == 1);
        $this->assertDatabaseHas('team_user', $assoc_data);

        $this->team->removeUser($this->user);
        $this->assertTrue($this->team->users()->count() == 0);
        $this->assertDatabaseMissing('team_user', $assoc_data);
    }
}
