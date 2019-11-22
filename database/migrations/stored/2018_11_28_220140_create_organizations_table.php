<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('organization_key')->nullable();
                $table->integer('default_address_key')->nullable();
                $table->integer('default_phone_number_key')->nullable();
                $table->integer('default_fax_number_key')->nullable();
                $table->integer('default_contact_person_key')->nullable();
                $table->integer('parent_organization_key')->nullable();
                $table->string('organization_name', 255)->nullable();
                $table->string('fed_id_number', 255)->nullable();
                $table->timestamp('last_edited', 3)->nullable();
                $table->tinyInteger('is_active')->nullable();
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
        Schema::dropIfExists('organizations');
    }
}