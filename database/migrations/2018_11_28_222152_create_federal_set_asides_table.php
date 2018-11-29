<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateFederalSetAsidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('federal_set_asides')) {
            Schema::create('federal_set_asides', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('federal_minimum_set_aside_key')->nullable();
                $table->string('set_aside_name', 255)->nullable();
                $table->string('set_aside_description')->nullable();
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
        Schema::dropIfExists('federal_set_asides');
    }
}
