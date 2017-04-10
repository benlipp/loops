<?php

use App\User;
use Illuminate\Database\Seeder;
use Loops\Models\Loop;
use Loops\Models\Note;
use Loops\Models\Project;

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
         $projects = factory(Project::class, 2)->create();
         foreach ($projects as $project)
         {
             $loop = factory(Loop::class)->make();
             $project->addLoop($loop)->save();
             $loop->addNote(new Note([
                 'body'   => '_test_ **markdown** document',
             ]), $user);


             $project->addUser($user)->save();
         }
    }
}
