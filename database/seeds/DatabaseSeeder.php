<?php

use App\User;
use Illuminate\Database\Seeder;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Project;
use Loops\Models\Team;

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
