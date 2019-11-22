<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateDefaultFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('default_followups')) {
            Schema::create('default_followups', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('finding_type_id')->nullable();
                $table->string('description', 255)->nullable();
                $table->integer('quantity')->nullable();
                $table->string('duration', 20)->nullable();
                $table->unsignedInteger('assigned_user_id')->nullable();
                $table->tinyInteger('reply')->nullable();
                $table->tinyInteger('photo')->nullable();
                $table->tinyInteger('doc')->nullable();
                $table->json('doc_categories')->nullable();
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
        Schema::dropIfExists('default_followups');
    }
}