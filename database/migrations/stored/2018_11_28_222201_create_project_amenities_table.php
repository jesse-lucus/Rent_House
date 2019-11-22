<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateProjectAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_amenities')) {
            Schema::create('project_amenities', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_amenity_key')->nullable();
                $table->unsignedInteger('amenity_id')->nullable();
                $table->integer('project_key')->nullable();
                $table->unsignedInteger('project_id')->nullable();
                $table->integer('project_program_key')->nullable();
                $table->unsignedInteger('project_program_id')->nullable();
                $table->integer('amenity_type_key')->nullable();
                $table->unsignedInteger('amenity_type_id')->nullable();
                $table->string('comment', 255)->nullable();
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
        Schema::dropIfExists('project_amenities');
    }
}