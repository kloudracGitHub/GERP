<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcEmppersonaldetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_emppersonaldetails', function (Blueprint $table) {
             $table->increments('id');
            $table->string('user_id',11)->nullable();   
            $table->string('genderid',11)->nullable();
            $table->string('maritalstatusid',11)->nullable();
            $table->string('nationalityid',11)->nullable();
            $table->string('languageid',11)->nullable();
            $table->date('dob')->nullable();
            $table->string('blood_group',20)->nullable();
            $table->longtext('identity_documents')->nullable();
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
        Schema::dropIfExists('grc_emppersonaldetails');
    }
}
