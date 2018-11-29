<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateSyncProjectDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sync_project_dates')) {
            Schema::create('sync_project_dates', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('allita_id')->nullable();
                $table->integer('project_date_key')->nullable();
                $table->integer('project_key')->nullable();
                $table->integer('project_program_key')->nullable();
                $table->integer('program_date_type_key')->nullable();
                $table->string('comment', 255)->nullable();
                $table->timestamp('event_date')->nullable();
                $table->timestamp('last_edited', 3)->nullable();
                $table->nullableTimestamps();

                

                

            });

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sync_project_dates');
    }
}
