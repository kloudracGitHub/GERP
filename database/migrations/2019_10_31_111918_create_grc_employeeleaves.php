<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcEmployeeleaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_employeeleaves', function (Blueprint $table) {
             $table->increments('id');
            $table->string('user_id',11)->nullable();  
            $table->float('emp_leave_limit')->nullable();
            $table->float('used_leaves')->nullable();
            $table->string('alloted_year',4)->nullable();
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
        Schema::dropIfExists('grc_employeeleaves');
    }
}
