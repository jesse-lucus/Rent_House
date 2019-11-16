<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1).
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateBoilerplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('boilerplates')) {
            Schema::create('boilerplates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255)->nullable();
                $table->text('boilerplate')->nullable();
                $table->unsignedInteger('creator_id')->nullable();
                $table->integer('global')->nullable();
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
        Schema::dropIfExists('boilerplates');
    }
}
