<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcGender extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_gender', function (Blueprint $table) {
             $table->increments('id');
            $table->string('gendercode',50)->nullable();
            $table->string('gendername',50)->nullable();
            $table->string('createdby',11)->nullable();
            $table->string('modifiedby',11)->nullable();
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
        Schema::dropIfExists('grc_gender');
    }
}
