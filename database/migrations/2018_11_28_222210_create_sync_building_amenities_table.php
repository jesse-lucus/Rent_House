<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateSyncBuildingAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('sync_building_amenities')) {
            Schema::create('sync_building_amenities', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('allita_id')->nullable();
                $table->integer('building_amenity_key')->nullable();
                $table->integer('building_key')->nullable();
                $table->integer('amenity_type_key')->nullable();
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
        Schema::dropIfExists('sync_building_amenities');
    }
}
