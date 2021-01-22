<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcEmpsalarydetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_empsalarydetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',11)->nullable();   
            $table->string('currency_id',11)->nullable();
            $table->string('salarytype',11)->nullable();
            $table->string('salary',100)->nullable();
            $table->string('bankname',100)->nullable();
            $table->string('department_name',100)->nullable();
            $table->date('accountholder_name')->nullable();
            $table->string('accountnumber',100)->nullable();
            $table->string('create_by',11)->nullable();
            $table->string('last_modified_by',11)->nullable();
            $table->timestamp('createddate');
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
        Schema::dropIfExists('grc_empsalarydetails');
    }
}
