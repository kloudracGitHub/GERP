<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcUsersSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_users_summary', function (Blueprint $table) {
             $table->increments('id');
            $table->string('user_id',11)->nullable();   
            $table->date('date_of_joining')->nullable();
            $table->date('date_of_leaving')->nullable();
            $table->string('reporting_manager',11)->nullable();
            $table->string('reporting_manager_name',60)->nullable();
            $table->string('emp_status',20)->nullable();
            $table->string('department_id',11)->nullable();
            $table->string('department_name',20)->nullable();
            $table->string('job_title_id',11)->nullable();
            $table->string('job_title',20)->nullable(); 
            $table->string('year_exp',20)->nullable();
            $table->string('mode_of_entry',20)->nullable();
            $table->string('create_by',11)->nullable();
            $table->string('create_by_name',11)->nullable();
            $table->string('last_modified_by',11)->nullable();
            $table->timestamp('create_date');
            $table->timestamp('last_modified_date');
            $table->tinyInteger('status',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grc_users_summary');
    }
}
