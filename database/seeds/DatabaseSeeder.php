<?php

use App\User;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Team;
use Loops\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $user = User::first();
        $team = factory(Team::class)->create();
        $team->addUser($user);
        $projects = factory(Project::class, 2)->make();
        foreach ($projects as $project) {
            $team->addProject($project);
            $loop = factory(Loop::class)->make();
            $project->addLoop($loop)->save();
            $loop->addNote(new Note([
                 'body'   => '_test_ **markdown** document',
             ]), $user);
        }
    }
}
