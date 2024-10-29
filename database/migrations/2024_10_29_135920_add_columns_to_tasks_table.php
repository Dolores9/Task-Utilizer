<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('title'); // Title of the task
            $table->text('description')->nullable(); // Description of the task
            $table->boolean('completed')->default(false); // Status of the task (completed or not)
            $table->date('due_date')->nullable(); // Due date of the task
            $table->integer('priority')->default(0); // Priority level of the task
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'completed', 'due_date', 'priority']);
        });
    }
}
