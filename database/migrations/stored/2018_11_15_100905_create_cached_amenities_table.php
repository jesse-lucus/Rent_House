<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateCachedAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cached_amenities')) {
            Schema::create('cached_amenities', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('audit_id');
                $table->unsignedInteger('project_id')->nullable();
                $table->unsignedInteger('building_id')->nullable();
                $table->unsignedInteger('unit_id')->nullable();
                $table->unsignedInteger('amenity_type_id')->nullable();
                $table->string('name', 250)->nullable();
                $table->string('status', 100)->nullable();
                $table->string('finding_nlt_status', 100)->nullable();
                $table->string('finding_lt_status', 100)->nullable();
                $table->string('finding_sd_status', 100)->nullable();
                $table->string('finding_photo_status', 100)->nullable();
                $table->string('finding_comment_status', 100)->nullable();
                $table->string('finding_copy_status', 100)->nullable();
                $table->string('finding_trash_status', 100)->nullable();
                $table->nullableTimestamps();
                $table->unsignedInteger('auditor_id')->nullable();
                $table->string('auditor_name', 100)->nullable();
                $table->string('auditor_color', 100)->nullable();
                $table->string('auditor_initials', 10)->nullable();
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
        Schema::dropIfExists('cached_amenities');
    }
}