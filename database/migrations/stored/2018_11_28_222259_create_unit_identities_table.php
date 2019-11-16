<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1).
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateUnitIdentitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('unit_identities')) {
            Schema::create('unit_identities', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('unit_identity_key')->nullable();
                $table->string('unit_identity_description', 255)->nullable();
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
        Schema::dropIfExists('unit_identities');
    }
}
