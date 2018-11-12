<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateCachedAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cached_audits'))
        {
            Schema::create('cached_audits', function (Blueprint $table) {
                $table->increments('id');
                $table->string('project_id', 100)->default('');
                $table->string('status', 100)->nullable();
                $table->integer('lead')->nullable();
                $table->json('lead_json')->nullable();
                $table->string('title', 250)->nullable();
                $table->string('pm', 250)->nullable();
                $table->string('address', 250)->nullable();
                $table->string('city', 250)->nullable();
                $table->string('state', 100)->nullable();
                $table->string('zip', 100)->nullable();
                $table->integer('total_buildings')->nullable();
                $table->string('inspection_status', 100)->nullable();
                $table->string('inspection_status_text', 250)->nullable();
                $table->date('inspection_schedule_date')->nullable();
                $table->string('inspection_schedule_text', 100)->nullable();
                $table->integer('inspectable_items')->nullable();
                $table->integer('total_items')->nullable();
                $table->string('audit_compliance_icon', 100)->nullable();
                $table->string('audit_compliance_status', 100)->nullable();
                $table->string('audit_compliance_status_text', 250)->nullable();
                $table->string('followup_status', 100)->nullable();
                $table->string('followup_status_text', 250)->nullable();
                $table->date('followup_date')->nullable();
                $table->string('file_audit_icon', 100)->nullable();
                $table->string('file_audit_status', 100)->nullable();
                $table->string('file_audit_status_text', 250)->nullable();
                $table->string('nlt_audit_icon', 100)->nullable();
                $table->string('nlt_audit_status', 100)->nullable();
                $table->string('nlt_audit_status_text', 250)->nullable();
                $table->string('lt_audit_icon', 100)->nullable();
                $table->string('lt_audit_status', 100)->nullable();
                $table->string('lt_audit_status_text', 250)->nullable();
                $table->string('smoke_audit_icon', 100)->nullable();
                $table->string('smoke_audit_status', 100)->nullable();
                $table->string('smoke_audit_status_text', 250)->nullable();
                $table->string('auditor_status_icon', 100)->nullable();
                $table->string('auditor_status', 100)->nullable();
                $table->string('auditor_status_text', 250)->nullable();
                $table->string('message_status_icon', 100)->nullable();
                $table->string('message_status', 100)->nullable();
                $table->string('message_status_text', 250)->nullable();
                $table->string('document_status_icon', 100)->nullable();
                $table->string('document_status', 100)->nullable();
                $table->string('document_status_text', 250)->nullable();
                $table->string('history_status_icon', 100)->nullable();
                $table->string('history_status', 100)->nullable();
                $table->string('history_status_text', 250)->nullable();
                $table->string('step_status_icon', 100)->nullable();
                $table->string('step_status', 100)->nullable();
                $table->string('step_status_text', 250)->nullable();
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
        Schema::dropIfExists('cached_audits');
    }
}
