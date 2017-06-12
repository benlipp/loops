<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToLoop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loops', function ($table) {
            $table->text('description')->after('name')->nullable();
        });

        $loops = \Loops\Models\Loop::all();
        foreach ($loops as $loop) {
            $loop->description = $loop->first_note->body;
            $loop->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loops', function ($table) {
            $table->dropColumn(['description']);
        });
    }
}
