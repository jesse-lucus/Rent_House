<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateProjectFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_financials')) {
            Schema::create('project_financials', function (Blueprint $table) {
                $table->integer('id');
                $table->integer('project_financial_key')->nullable();
                $table->integer('project_key')->nullable();
                $table->unsignedInteger('project_id')->nullable();
                $table->integer('project_program_key')->nullable();
                $table->unsignedInteger('project_program_id')->nullable();
                $table->integer('funding_program_key')->nullable();
                $table->unsignedInteger('funding_program_id')->nullable();
                $table->integer('financial_type_key')->nullable();
                $table->unsignedInteger('financial_type_id')->nullable();
                $table->float('amount')->nullable();
                $table->timestamp('last_edited', 3)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();

                $table->primary('id');
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
        Schema::dropIfExists('project_financials');
    }
}
