<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcEmpexperiancedetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_empexperiancedetail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',11)->nullable();   
            $table->string('comp_name',100)->nullable();
            $table->string('comp_website',100)->nullable();
            $table->string('designation',100)->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('reson_for_leaving',100)->nullable();
            $table->string('reference_name',100)->nullable();
            $table->string('reference_contact',100)->nullable();
            $table->string('reference_email',100)->nullable();
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
        Schema::dropIfExists('grc_empexperiancedetail');
    }
}
