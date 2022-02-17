<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('location_id')->constrained();
            $table->foreignId('category_id')->constrained();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('status', ['open', 'close']);
            $table->enum('type', ['permanent', 'contract', 'internship']);
            $table->enum('level', ['entry', 'mid', 'senior']);
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
        Schema::dropIfExists('jobs');
    }
}
