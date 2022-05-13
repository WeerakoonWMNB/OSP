<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryHsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_hs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number')->unique();
            $table->string('f_name');
            $table->string('email');
            $table->string('contact_number');
            $table->boolean('mark_as_read')->default(0);
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
        Schema::dropIfExists('inquiry_hs');
    }
}
