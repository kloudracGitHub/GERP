<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_user', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('employee_id');   
            $table->string('first_name',20);
            $table->string('middle_name',20);
            $table->string('last_name',20);
            $table->string('user_name',20);
            $table->string('email',60);
            $table->string('password',255);
            $table->string('role',100);
            $table->string('pancard_no',100);
            $table->string('uan_number',100);
            $table->string('desgination',50);
            $table->string('dob',50);
            $table->string('gender',2);
            $table->string('mobile_no',20);
            $table->string('alternate_no',20);
            $table->string('address',20);
            $table->string('city',50);
            $table->string('state',50);
            $table->string('pincode',50);
            $table->string('country',50);
            $table->string('photo',255);
            //$table->timestamp('created_at') ;
           //$table->timestamp('updated_at');
            $table->rememberToken();
            $table->string('status',1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grc_user');
    }
}
