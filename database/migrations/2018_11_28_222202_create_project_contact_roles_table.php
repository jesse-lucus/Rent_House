<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateProjectContactRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_contact_roles')) {
            Schema::create('project_contact_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_contact_role_key')->nullable();
                $table->integer('project_key')->nullable();
                $table->integer('project_program_key')->nullable();
                $table->integer('person_key')->nullable();
                $table->integer('project_role_key')->nullable();
                $table->integer('organization_key')->nullable();
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
        Schema::dropIfExists('project_contact_roles');
    }
}
