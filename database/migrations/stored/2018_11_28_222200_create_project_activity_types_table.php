<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateProjectActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_activity_types')) {
            Schema::create('project_activity_types', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_activity_type_key')->nullable();
                $table->string('activity_name', 255)->nullable();
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
        Schema::dropIfExists('project_activity_types');
    }
}
