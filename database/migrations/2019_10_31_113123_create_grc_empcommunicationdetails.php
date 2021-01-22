<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcEmpcommunicationdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_empcommunicationdetails', function (Blueprint $table) {
             $table->increments('id');
            $table->string('user_id',11)->nullable();   
            $table->string('personalemail',100)->nullable();
            $table->string('personal_streetaddress',100)->nullable();
            $table->string('perm_country',11)->nullable();
            $table->string('perm_state',11)->nullable();
            $table->string('perm_city',11)->nullable();
            $table->string('perm_pincode',100)->nullable();
            $table->string('current_streetaddress',100)->nullable();
            $table->string('current_country',11)->nullable();
            $table->string('current_state',11)->nullable();
            $table->string('current_city',11)->nullable();
            $table->string('current_pincode',100)->nullable();
            $table->string('emergency_number',100)->nullable();
            $table->string('emergency_name',100)->nullable();
            $table->string('emergency_email',100)->nullable();
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
        Schema::dropIfExists('grc_empcommunicationdetails');
    }
}
