<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNuggetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nuggets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('nuggetable_type');
            $table->uuid('nuggetable_id');
            $table->integer('sort_order')->nullable();
            $table->string('name')->nullable();
            $table->string('data', 4096)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nuggets');
    }
}
